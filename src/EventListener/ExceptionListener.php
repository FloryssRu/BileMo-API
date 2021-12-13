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

        $message = sprintf(
            '%s : code %s',
            $exception->getMessage(),
            $exception->getCode()
        );
            
        $response = new JsonResponse();
        $response->setContent('{ "erreur": "' . $message . '"}');

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
    /*$request = $event->getRequest();
    if (in_array("* /*", $request->getAcceptableContentTypes()) || in_array("application/json", $request->getAcceptableContentTypes()))*/
}