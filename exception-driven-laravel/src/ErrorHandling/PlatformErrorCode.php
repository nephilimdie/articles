<?php
declare(strict_types=1);

namespace ExceptionDriven\ErrorHandling;

enum PlatformErrorCode: string implements ErrorCodeInterface
{
    case INTERNAL_SERVER_ERROR = 'INTERNAL_SERVER_ERROR';

    public function responseCode(): string
    {
        return $this->value;
    }

    public function translationKey(): string
    {
        return match ($this) {
            self::INTERNAL_SERVER_ERROR => 'errors.platform.internal_server_error',
        };
    }
}
