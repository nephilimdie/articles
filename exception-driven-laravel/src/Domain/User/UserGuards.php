<?php
declare(strict_types=1);

namespace ExceptionDriven\Domain\User;

use ExceptionDriven\Domain\User\Exceptions\EmailAlreadyTakenException;

final class UserGuards
{
    public static function emailIsAvailable(string $email, bool $isAvailable): void
    {
        if (!$isAvailable) {
            throw new EmailAlreadyTakenException($email);
        }
    }
}

