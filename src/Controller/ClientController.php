<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/clients")
 */
class ClientController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route(name="api_client_list", methods={"GET"})
     */
    public function collection(ClientRepository $clientRepository): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($clientRepository->findAll(), "json"),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/{id}", name="api_client_item", methods={"GET"})
     */
    public function item(int $id, ClientRepository $clientRepository): JsonResponse
    {
        $client = $clientRepository->findOneBy(['id' => $id]);

        return new JsonResponse(
            $this->serializer->serialize($client, "json"),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/create", name="api_client_create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $client = $this->serializer->deserialize($request->getContent(), Client::class, 'json');

        // set the user here
        //client->setUser();

        $em->persist($client);
        $em->flush();

        return new JsonResponse(
            $this->serializer->serialize($client, 'json', ['groups' => 'create']),
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }

    /**
     * @Route("/delete/{id}", name="api_client_delete", methods={"DELETE"})
     */
    public function delete(int $id, ClientRepository $clientRepository, EntityManagerInterface $em): JsonResponse
    {
        $client = $clientRepository->findOneBy(['id' => $id]);

        $em->remove($client);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
