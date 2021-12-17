<?php

namespace App\Controller;

use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApiLoginController extends AbstractController
{
    /**
     * Route to get a token
     * 
     * @Route("/login", name="api_login", methods={"POST"})
     * @OA\Response(
     *      response=200,
     *      description="Give you a bearer token"
     * )
     * @OA\Parameter(
     *     name="email",
     *     in="query",
     *     description="The email of a client",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="password",
     *     in="query",
     *     description="The password of the same client",
     *     @OA\Schema(type="string")
     * )
     * @OA\Tag(name="login")
     */
    public function index()
    {

    }
}
