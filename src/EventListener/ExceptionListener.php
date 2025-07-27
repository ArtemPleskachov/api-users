<?php

namespace App\EventListener;

use App\Exception\Request\ValidationException;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
    
        if ($exception instanceof ValidationException) {
            $event->setResponse(new JsonResponse([
                'success' => false,
                'errors' => $exception->getErrors()
            ], 422));
            return;
        }
    
        if (
            $exception instanceof HttpExceptionInterface &&
            $exception->getPrevious() instanceof JsonResponse
        ) {
            $event->setResponse($exception->getPrevious());
            return;
        }
    
        $event->setResponse(new JsonResponse([
            'success' => false,
            'message' => $exception->getMessage(),
        ], $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500));
    }
}