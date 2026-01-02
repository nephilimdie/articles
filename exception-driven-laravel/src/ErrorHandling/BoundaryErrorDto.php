<?php

declare(strict_types=1);

namespace ExceptionDriven\ErrorHandling;

use Psr\Log\LogLevel;

final class BoundaryErrorDto
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
        public readonly string $correlationId = '',
    ) {}

    public function responseCode(): string
    {
        return $this->code->responseCode();
    }

    // DTO is immutable; construct it once at the boundary via the adapter.

    /**
     * Prepare a structured array for logging context.
     *
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'response_code' => $this->responseCode(),
            'log_level' => $this->logLevel,
            'message_key' => $this->messageKey,
            'message_params' => $this->messageParams,
            'meta' => $this->meta,
            'correlation_id' => $this->correlationId,
            'context' => $this->logContext,
        ];
    }
}
