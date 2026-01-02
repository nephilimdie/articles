<?php
declare(strict_types=1);

namespace ExceptionDriven\Domain\User;

use ExceptionDriven\ErrorHandling\ErrorCodeInterface;

enum UserErrorCode: string implements ErrorCodeInterface
{
    case USER_NOT_FOUND = 'USER_NOT_FOUND';
    case EMAIL_ALREADY_TAKEN = 'USER_EMAIL_ALREADY_TAKEN';

    public function responseCode(): string
    {
        return $this->value;
    }

    public function translationKey(): string
    {
        return match ($this) {
            self::USER_NOT_FOUND => 'errors.user.not_found',
            self::EMAIL_ALREADY_TAKEN => 'errors.user.email_already_taken',
        };
    }
}

