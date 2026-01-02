<?php
declare(strict_types=1);

namespace ExceptionDriven\Domain\User\Policy;

use ExceptionDriven\Domain\User\UserErrorCode;
use ExceptionDriven\ErrorHandling\ErrorCodeInterface;
use ExceptionDriven\Policy\TransportOutcome;
use ExceptionDriven\Policy\TransportPolicyProviderInterface;
use Symfony\Component\HttpFoundation\Response;

final class UserTransportPolicyProvider implements TransportPolicyProviderInterface
{
    public function supports(ErrorCodeInterface $code): bool
    {
        return $code instanceof UserErrorCode;
    }

    public function outcome(ErrorCodeInterface $code): TransportOutcome
    {
        /** @var UserErrorCode $code */
        return match ($code) {
            UserErrorCode::USER_NOT_FOUND => new TransportOutcome(Response::HTTP_NOT_FOUND, 1, 5),
            UserErrorCode::EMAIL_ALREADY_TAKEN => new TransportOutcome(Response::HTTP_CONFLICT, 1, 6),
        };
    }
}

