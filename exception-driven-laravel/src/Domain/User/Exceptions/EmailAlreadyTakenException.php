<?php
declare(strict_types=1);

namespace ExceptionDriven\Domain\User\Exceptions;

use ExceptionDriven\Domain\User\UserErrorCode;
use ExceptionDriven\ErrorHandling\ErrorCodeInterface;
use ExceptionDriven\Exceptions\ApiException;
use Psr\Log\LogLevel;

final class EmailAlreadyTakenException extends ApiException
{
    public const LOG_LEVEL = LogLevel::INFO;

    public function __construct(private string $email)
    {
        parent::__construct();
    }

    public static function code(): ErrorCodeInterface
    {
        return UserErrorCode::EMAIL_ALREADY_TAKEN;
    }

    public function publicMeta(): array
    {
        return ['email' => $this->email];
    }

    public function category(): string
    {
        return 'conflict';
    }

    public function isExpected(): bool
    {
        return true;
    }
}
