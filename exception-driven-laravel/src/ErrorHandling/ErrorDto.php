<?php

declare(strict_types=1);

namespace ExceptionDriven\ErrorHandling;

use Psr\Log\LogLevel;

final class ErrorDto
{
    /**
     * @param array<string,mixed> $messageParams
     * @param array<string,mixed> $meta
     * @param array<string,mixed> $logContext
     */
    public function __construct(
        public readonly ErrorCodeInterface $code,
        public readonly string $messageKey,
        public readonly array $messageParams = [],
        public readonly string $logLevel = LogLevel::ERROR,
        public readonly array $meta = [],
        public readonly array $logContext = [],
        public readonly string $errorId = '',
    ) {}

    public function responseCode(): string
    {
        return $this->code->responseCode();
    }

    // DTO is immutable; construct it once at the boundary via the adapter.
}
