<?php
declare(strict_types=1);

namespace ExceptionDriven\Policy;

use ExceptionDriven\ErrorHandling\ErrorCodeInterface;
use ExceptionDriven\ErrorHandling\PlatformErrorCode;
use Symfony\Component\HttpFoundation\Response;

final class PlatformTransportPolicyProvider implements TransportPolicyProviderInterface
{
    public function supports(ErrorCodeInterface $code): bool
    {
        return $code instanceof PlatformErrorCode;
    }

    public function outcome(ErrorCodeInterface $code): TransportOutcome
    {
        return new TransportOutcome(Response::HTTP_INTERNAL_SERVER_ERROR, 1, 13);
    }
}

