<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Services\HandlerAddLinks;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
     * Lists the collection of all the phones in database.
     * 
     * @Route(name="api_product_list", methods={"GET"})
     * @OA\Response(
     *      response=200,
     *      description="Lists the phone collection"
     * )
     * @OA\Tag(name="products")
     * @Security(name="Bearer")
     */
    public function collection(Request $request): JsonResponse
    {
        if (0 < intval($request->query->get("page"))) {
            $page = intval($request->query->get("page"));
        } else {
            $page = 1;
        }

        $this->paginator = $this->productRepository->getProductPaginator($page);

        $response = $this->cache->get('products_collection_' . $page, function (ItemInterface $item) {
            $item->expiresAfter(3600);

            $handlerAddLinks = new HandlerAddLinks();
            $responseWithLinks = $handlerAddLinks->addLinksCollection($this->paginator);

            return $this->serializer->serialize($responseWithLinks, "json");

            // return $this->serializer->serialize($this->paginator, "json");
        });

        return new JsonResponse(
            $response,
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * Finds and returns the product associate to the id given
     * 
     * @Route("/{id}", name="api_product_item", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns a product"
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The field used to find the product",
     *     @OA\Schema(type="int")
     * )
     * @OA\Tag(name="products")
     * @Security(name="Bearer")
     */
    public function item($id): JsonResponse
    {
        $this->id = intval($id);

        $response = $this->cache->get('products_item_' . $this->id, function (ItemInterface $item) {
            $item->expiresAfter(3600);

            if ($this->productRepository->findOneBy(['id' => $this->id]) === NULL || !is_int($this->id)) {
                throw new HttpException(404);
            }

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
