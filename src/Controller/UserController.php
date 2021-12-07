<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @Route("/users")
 */
class UserController extends AbstractController
{
    private $serializer;

    private $cache;

    private $userRepository;

    public function __construct(SerializerInterface $serializer, UserRepository $userRepository)
    {
        $this->serializer = $serializer;
        $this->cache = new FilesystemAdapter();
        $this->userRepository = $userRepository;
    }

    /**
     * @Route(name="api_user_list", methods={"GET"})
     */
    public function collection(): JsonResponse
    {
        $response = $this->cache->get('users_collection', function (ItemInterface $item) {
            $item->expiresAfter(3600);

            return $this->serializer->serialize($this->userRepository->findAll(), "json", ['groups' => 'get']);
        });

        return new JsonResponse(
            $response,
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/{id}", name="api_user_item", methods={"GET"})
     */
    public function item(int $id): JsonResponse
    {
        $this->id = $id;

        $response = $this->cache->get('users_item_' . $this->id, function (ItemInterface $item) {
            $item->expiresAfter(3600);

            return $this->serializer->serialize($this->userRepository->findOneBy(['id' => $this->id]), "json", ['groups' => 'get']);
        });

        return new JsonResponse(
            $response,
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/create", name="api_user_create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');

        $user->setClient($this->getUser());

        $em->persist($user);
        $em->flush();

        return new JsonResponse(
            $this->serializer->serialize($user, 'json', ['groups' => 'create']),
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }

    /**
     * @Route("/delete/{id}", name="api_user_delete", methods={"DELETE"})
     */
    public function delete(int $id, UserRepository $userRepository, EntityManagerInterface $em): JsonResponse
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        $em->remove($user);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
