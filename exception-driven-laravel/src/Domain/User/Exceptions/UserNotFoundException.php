<?php
declare(strict_types=1);

namespace ExceptionDriven\Domain\User\Exceptions;

use ExceptionDriven\Domain\User\UserErrorCode;
use ExceptionDriven\ErrorHandling\ErrorCodeInterface;
use ExceptionDriven\Exceptions\ApiException;
use Psr\Log\LogLevel;

final class UserNotFoundException extends ApiException
{
    public const LOG_LEVEL = LogLevel::INFO;

    public function __construct(private string $userId)
    {
        parent::__construct('User not found');
    }

    public static function code(): ErrorCodeInterface
    {
        return UserErrorCode::USER_NOT_FOUND;
    }

    public function publicMeta(): array
    {
        return ['user_id' => $this->userId];
    }
}

