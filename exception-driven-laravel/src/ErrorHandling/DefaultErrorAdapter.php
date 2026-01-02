<?php
declare(strict_types=1);

namespace ExceptionDriven\ErrorHandling;

use ExceptionDriven\Exceptions\ApiExceptionInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Psr\Log\LogLevel;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

final class DefaultErrorAdapter implements ErrorAdapterInterface
{
    public function toDto(Throwable $throwable, string $correlationId): BoundaryErrorDto
    {
        if ($throwable instanceof ApiExceptionInterface) {
            $code = $throwable->codeEnum();

            return new BoundaryErrorDto(
                code: $code,
                messageKey: $code->translationKey(),
                messageParams: $throwable->messageParams(),
                logLevel: $throwable->logLevel(),
                meta: $throwable->publicMeta(),
                logContext: $throwable->context(),
                correlationId: $correlationId,
                category: $throwable->category(),
                retryable: $throwable->retryable(),
                isExpected: $throwable->isExpected(),
            );
        }

        // Map common platform/framework exceptions first
        if ($throwable instanceof AuthenticationException) {
            $code = PlatformErrorCode::UNAUTHENTICATED;
        } elseif ($throwable instanceof AuthorizationException) {
            $code = PlatformErrorCode::FORBIDDEN;
        } elseif ($throwable instanceof ValidationException) {
            $code = PlatformErrorCode::VALIDATION_FAILED;
        } elseif ($throwable instanceof ModelNotFoundException) {
            $code = PlatformErrorCode::NOT_FOUND;
        } elseif ($throwable instanceof HttpExceptionInterface) {
            $status = $throwable->getStatusCode();
            $code = match ($status) {
                401 => PlatformErrorCode::UNAUTHENTICATED,
                403 => PlatformErrorCode::FORBIDDEN,
                404 => PlatformErrorCode::NOT_FOUND,
                422 => PlatformErrorCode::VALIDATION_FAILED,
                default => PlatformErrorCode::INTERNAL_SERVER_ERROR,
            };
        } else {
            // Fallback for any unexpected Throwable
            $code = PlatformErrorCode::INTERNAL_SERVER_ERROR;
        }

        // Defaults for platform exceptions
        $category = match ($code) {
            PlatformErrorCode::UNAUTHENTICATED => 'auth',
            PlatformErrorCode::FORBIDDEN => 'forbidden',
            PlatformErrorCode::VALIDATION_FAILED => 'validation',
            PlatformErrorCode::NOT_FOUND => 'not_found',
            default => 'internal',
        };
        $isExpected = in_array($code, [
            PlatformErrorCode::UNAUTHENTICATED,
            PlatformErrorCode::FORBIDDEN,
            PlatformErrorCode::VALIDATION_FAILED,
            PlatformErrorCode::NOT_FOUND,
        ], true);

        return new BoundaryErrorDto(
            code: $code,
            messageKey: $code->translationKey(),
            messageParams: [],
            logLevel: LogLevel::ERROR,
            meta: [],
            logContext: [
                'exception_class' => get_class($throwable),
                'exception_message' => $throwable->getMessage(), // avoid PII
                'exception_code' => $throwable->getCode(),
                'exception_file' => $throwable->getFile(),
                'exception_line' => $throwable->getLine(),
                'exception_fingerprint' => sprintf('%s@%s:%d', get_class($throwable), $throwable->getFile(), $throwable->getLine()),
            ],
            correlationId: $correlationId,
            category: $category,
            retryable: false,
            isExpected: $isExpected,
        );
    }
}
