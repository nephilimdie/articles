<?php
declare(strict_types=1);

namespace ExceptionDriven\Exceptions;

use ExceptionDriven\ErrorHandling\ErrorCodeInterface;
use Exception;
use Psr\Log\LogLevel;

abstract class ApiException extends Exception implements ApiExceptionInterface
{
    public function __construct()
    {
        parent::__construct(static::code()->responseCode());
    }
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

    public function category(): string
    {
        return 'internal';
    }

    public function retryable(): bool
    {
        return false;
    }

    public function isExpected(): bool
    {
        return false;
    }
}
