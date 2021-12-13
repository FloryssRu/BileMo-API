<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
            
        $response = new JsonResponse();

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());

            switch ($exception->getStatusCode()) {
                case 403:
                    $message = "Vous n'avez pas les droits requis.";
                    break;
                case 404:
                    $message = "L'information n'existe pas.";
                    break;
                case 500:
                    $message = "Une erreur serveur est survenue.";
                    break;
                default:
                    $message = "Une erreur est survenue.";
                    break;
            }

            $response->setContent('{"code": "' . $exception->getStatusCode() . '", "erreur": "' . $message . '"}');
        } else {
            $response->setContent('{"code": "500", "erreur": "Une erreur est survenue."}');
            $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}