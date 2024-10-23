<?php

declare(strict_types=1);

namespace App\Listener;

use App\Model\ErrorDebugDetails;
use App\Model\ErrorResponse;
use App\Service\ExceptionHandler\ExceptionMapping;
use App\Service\ExceptionHandler\ExceptionMappingResolver;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ApiExceptionListener
{
    public function __construct(
        private readonly ExceptionMappingResolver $resolver,
        private readonly LoggerInterface $logger,
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        $mapping = $this->resolver->resolve($throwable::class);
        if (null === $mapping) {
            $mapping = ExceptionMapping::fromCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($mapping->getCode() >= Response::HTTP_INTERNAL_SERVER_ERROR || $mapping->isLoggable()) {
            $this->logger->error($throwable->getMessage(), [
                'trace' => $throwable->getTraceAsString(),
                'previous' => null !== $throwable->getPrevious() ? $throwable->getPrevious()->getMessage() : '',
            ]);
        }

        $message = $mapping->isHidden()
            ? Response::$statusTexts[$mapping->getCode()]
            : $throwable->getMessage();

        $data = $this->serializer->serialize(new ErrorResponse($message), JsonEncoder::FORMAT);

        $event->setResponse(new JsonResponse($data, $mapping->getCode(), [], true));
    }

    private function isSecurityException(\Throwable $throwable): bool
    {
        return $throwable instanceof AuthenticationException || $throwable instanceof AccessDeniedException;
    }
}
