<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/users")
 */
class UserController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route(name="api_user_list", methods={"GET"})
     */
    public function collection(UserRepository $userRepository): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($userRepository->findAll(), "json"),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/{id}", name="api_user_item", methods={"GET"})
     */
    public function item(int $id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        return new JsonResponse(
            $this->serializer->serialize($user, "json"),
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

        // set the client here
        //user->setClient();

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
