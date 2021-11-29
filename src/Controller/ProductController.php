<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/products")
 */
class ProductController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route(name="api_product_list", methods={"GET"})
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

    /**
     * @Route("/{id}", name="api_product_item", methods={"GET"})
     */
    public function item(int $id, ProductRepository $productRepository): JsonResponse
    {
        $product = $productRepository->findOneBy(['id' => $id]);

        return new JsonResponse(
            $this->serializer->serialize($product, "json"),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }
}
