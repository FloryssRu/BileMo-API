<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\HandlerAddLinks;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
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
     * Lists the collection of all the users in database.
     * 
     * @Route(name="api_user_list", methods={"GET"})
     * @OA\Response(
     *      response=200,
     *      description="Lists the collection of users"
     * )
     * @OA\Tag(name="users")
     * @Security(name="Bearer")
     */
    public function collection(Request $request): JsonResponse
    {
        if (0 < intval($request->query->get("page"))) {
            $page = intval($request->query->get("page"));
        } else {
            $page = 1;
        }

        $this->paginator = $this->userRepository->getUserPaginator($page);

        $response = $this->cache->get('users_collection_' . $page, function (ItemInterface $item) {
            $item->expiresAfter(3600);

            $handlerAddLinks = new HandlerAddLinks();
            $responseWithLinks = $handlerAddLinks->addLinksCollection($this->paginator);

            return $this->serializer->serialize($responseWithLinks, "json", ['groups' => 'get']);
        });

        return new JsonResponse(
            $response,
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * Create a new user with the data given
     * 
     * @Route("/create", name="api_user_create", methods={"POST"})
     * @OA\Response(
     *     response=201,
     *     description="Creates an user"
     * )
     * @OA\Tag(name="users")
     * @Security(name="Bearer")
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
     * Finds and return the user associate to the id given
     * 
     * @Route("/{id}", name="api_user_item", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns an user"
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The field used to find the user",
     *     @OA\Schema(type="int")
     * )
     * @OA\Tag(name="users")
     * @Security(name="Bearer")
     */
    public function item($id): JsonResponse
    {
        $this->id = intval($id);

        $response = $this->cache->get('users_item_' . $this->id, function (ItemInterface $item) {
            $item->expiresAfter(3600);

            if ($this->userRepository->findOneBy(['id' => $this->id]) === NULL || !is_int($this->id)) {
                throw new HttpException(404);
            }

            $handlerAddLinks = new HandlerAddLinks();
            $responseWithLinks = $handlerAddLinks->addLinksItem($this->userRepository->findOneBy(['id' => $this->id]));

            return $this->serializer->serialize($responseWithLinks, "json", ['groups' => 'get']);
        });

        return new JsonResponse(
            $response,
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * Finds, modifies with the data given and return the user associate to the id given
     * 
     * @Route("/edit/{id}", name="api_user_put", methods={"PUT"})
     * @OA\Response(
     *     response=200,
     *     description="Edit an user"
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The field used to find the user",
     *     @OA\Schema(type="int")
     * )
     * @OA\Tag(name="users")
     * @Security(name="Bearer")
     */
    public function put(Request $request, EntityManagerInterface $em, int $id): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        $user = $this->serializer->deserialize(
            $request->getContent(),
            User::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $user]
        );

        $em->flush();

        return new JsonResponse(
            $this->serializer->serialize($user, 'json', ['groups' => 'create']),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * Delete the user related to the id given
     * 
     * @Route("/delete/{id}", name="api_user_delete", methods={"DELETE"})
     * @OA\Response(
     *     response=204,
     *     description="Delete an user"
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The field used to find the user",
     *     @OA\Schema(type="int")
     * )
     * @OA\Tag(name="users")
     * @Security(name="Bearer")
     */
    public function delete(int $id, UserRepository $userRepository, EntityManagerInterface $em): JsonResponse
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        $em->remove($user);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
