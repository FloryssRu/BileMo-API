<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
}
