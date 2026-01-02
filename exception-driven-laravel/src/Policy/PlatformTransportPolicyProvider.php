<?php
declare(strict_types=1);

namespace ExceptionDriven\Policy;

use ExceptionDriven\ErrorHandling\ErrorCodeInterface;
use ExceptionDriven\ErrorHandling\PlatformErrorCode;
use Symfony\Component\HttpFoundation\Response;
use ExceptionDriven\Policy\GrpcStatus;

final class PlatformTransportPolicyProvider implements TransportPolicyProviderInterface
{
    public function supports(ErrorCodeInterface $code): bool
    {
        return $code instanceof PlatformErrorCode;
    }

    public function outcome(ErrorCodeInterface $code): TransportOutcome
    {
        if ($code instanceof PlatformErrorCode) {
            return match ($code) {
                PlatformErrorCode::UNAUTHENTICATED => new TransportOutcome(Response::HTTP_UNAUTHORIZED, 1, GrpcStatus::UNAUTHENTICATED),
                PlatformErrorCode::FORBIDDEN => new TransportOutcome(Response::HTTP_FORBIDDEN, 1, GrpcStatus::PERMISSION_DENIED),
                PlatformErrorCode::VALIDATION_FAILED => new TransportOutcome(Response::HTTP_UNPROCESSABLE_ENTITY, 1, GrpcStatus::INVALID_ARGUMENT),
                PlatformErrorCode::NOT_FOUND => new TransportOutcome(Response::HTTP_NOT_FOUND, 1, GrpcStatus::NOT_FOUND),
                PlatformErrorCode::INTERNAL_SERVER_ERROR => new TransportOutcome(Response::HTTP_INTERNAL_SERVER_ERROR, 1, GrpcStatus::INTERNAL),
            };
        }
        return new TransportOutcome(Response::HTTP_INTERNAL_SERVER_ERROR, 1, GrpcStatus::INTERNAL);
    }
}
