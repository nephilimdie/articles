<?php
declare(strict_types=1);

namespace ExceptionDriven\ErrorHandling;

use ExceptionDriven\Exceptions\ApiExceptionInterface;
use Psr\Log\LogLevel;
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
            );
        }

        // Fallback for any unexpected Throwable
        $code = PlatformErrorCode::INTERNAL_SERVER_ERROR;

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
        );
    }
}
