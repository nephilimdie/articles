<?php
declare(strict_types=1);

namespace ExceptionDriven\Exceptions;

use ExceptionDriven\ErrorHandling\ErrorCodeInterface;
use Exception;
use Psr\Log\LogLevel;

abstract class ApiException extends Exception implements ApiExceptionInterface
{
    /**
     * Each exception must map to a domain-owned error code.
     */
    abstract public static function code(): ErrorCodeInterface;

    /**
     * PSR-3 severity. Concrete exceptions override via constant.
     */
    public const LOG_LEVEL = LogLevel::ERROR;

    final public function codeEnum(): ErrorCodeInterface
    {
        return static::code();
    }

    final public function logLevel(): string
    {
        return static::LOG_LEVEL;
    }

    /**
     * Translation placeholders.
     *
     * @return array<string,mixed>
     */
    public function messageParams(): array
    {
        return [];
    }

    /**
     * Extra structured info for logs (internal).
     *
     * @return array<string,mixed>
     */
    public function context(): array
    {
        return [];
    }

    /**
     * Extra structured info safe for clients.
     *
     * @return array<string,mixed>
     */
    public function publicMeta(): array
    {
        return [];
    }
}
