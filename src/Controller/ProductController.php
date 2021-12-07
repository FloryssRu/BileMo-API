<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @Route("/products")
 */
class ProductController extends AbstractController
{
    private $serializer;

    private $cache;

    private $productRepository;

    public function __construct(SerializerInterface $serializer, ProductRepository $productRepository)
    {
        $this->serializer = $serializer;
        $this->cache = new FilesystemAdapter();
        $this->productRepository = $productRepository;
    }

    /**
     * @Route(name="api_product_list", methods={"GET"})
     */
    public function collection(): JsonResponse
    {
        $response = $this->cache->get('products_collection', function (ItemInterface $item) {
            $item->expiresAfter(3600);

            return $this->serializer->serialize($this->productRepository->findAll(), "json");
        });

        return new JsonResponse(
            $response,
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/{id}", name="api_product_item", methods={"GET"})
     */
    public function item(int $id): JsonResponse
    {
        $this->id = $id;

        $response = $this->cache->get('products_item_' . $this->id, function (ItemInterface $item) {
            $item->expiresAfter(3600);

            return $this->serializer->serialize($this->productRepository->findOneBy(['id' => $this->id]), "json");
        });

        return new JsonResponse(
            $response,
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }
}
