<?php
declare(strict_types=1);

namespace ExceptionDriven\Exceptions;

use ExceptionDriven\ErrorHandling\ErrorCodeInterface;
use Throwable;

interface ApiExceptionInterface extends Throwable
{
    public function codeEnum(): ErrorCodeInterface;

    /**
     * PSR-3 severity level (e.g. LogLevel::INFO).
     */
    public function logLevel(): string;

    /**
     * Translation placeholders.
     *
     * @return array<string,mixed>
     */
    public function messageParams(): array;

    /**
     * Extra structured info for logs (internal).
     *
     * @return array<string,mixed>
     */
    public function context(): array;

    /**
     * Extra structured info safe for clients.
     *
     * @return array<string,mixed>
     */
    public function publicMeta(): array;

    /** Semantic category (validation, auth, not_found, conflict, rate_limit, internal, dependency). */
    public function category(): string;

    /** Whether the operation can be retried (without changing inputs). */
    public function retryable(): bool;

    /** Whether this failure is expected in normal operation (e.g., validation). */
    public function isExpected(): bool;
}
