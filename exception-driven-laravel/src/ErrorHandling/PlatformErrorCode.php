<?php
declare(strict_types=1);

namespace ExceptionDriven\ErrorHandling;

enum PlatformErrorCode: string implements ErrorCodeInterface
{
    case INTERNAL_SERVER_ERROR = 'INTERNAL_SERVER_ERROR';
    case UNAUTHENTICATED = 'UNAUTHENTICATED';
    case FORBIDDEN = 'FORBIDDEN';
    case VALIDATION_FAILED = 'VALIDATION_FAILED';
    case NOT_FOUND = 'NOT_FOUND';

    public function responseCode(): string
    {
        return $this->value;
    }

    public function translationKey(): string
    {
        return match ($this) {
            self::INTERNAL_SERVER_ERROR => 'errors.platform.internal_server_error',
            self::UNAUTHENTICATED => 'errors.platform.unauthenticated',
            self::FORBIDDEN => 'errors.platform.forbidden',
            self::VALIDATION_FAILED => 'errors.platform.validation_failed',
            self::NOT_FOUND => 'errors.platform.not_found',
        };
    }
}
