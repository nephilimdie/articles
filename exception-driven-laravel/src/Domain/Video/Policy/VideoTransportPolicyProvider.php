<?php

declare(strict_types=1);

namespace ExceptionDriven\Domain\Video\Policy;

use ExceptionDriven\Domain\Video\VideoErrorCode;
use ExceptionDriven\ErrorHandling\ErrorCodeInterface;
use ExceptionDriven\Policy\TransportOutcome;
use ExceptionDriven\Policy\TransportPolicyProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use ExceptionDriven\Policy\GrpcStatus;

final class VideoTransportPolicyProvider implements TransportPolicyProviderInterface
{
    public function supports(ErrorCodeInterface $code): bool
    {
        return $code instanceof VideoErrorCode;
    }

    public function outcome(ErrorCodeInterface $code): TransportOutcome
    {
        /** @var VideoErrorCode $code */
        return match ($code) {
            VideoErrorCode::THUMBNAIL_INVALID_DIMENSIONS => new TransportOutcome(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                1,
                GrpcStatus::INVALID_ARGUMENT
            ),
            VideoErrorCode::VIDEO_NOT_FOUND => new TransportOutcome(
                Response::HTTP_NOT_FOUND,
                1,
                GrpcStatus::NOT_FOUND
            ),
        };
    }
}
