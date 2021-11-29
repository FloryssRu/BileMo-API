<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/products", name="api_product_list", methods={"GET"})
     */
    public function collection(ProductRepository $productRepository): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($productRepository->findAll(), "json"),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }
}
