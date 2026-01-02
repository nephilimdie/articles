<?php
declare(strict_types=1);

namespace ExceptionDriven\Policy;

use ExceptionDriven\ErrorHandling\ErrorCodeInterface;
use Psr\Log\LoggerInterface;

final class DefaultTransportPolicy implements TransportPolicyInterface
{
    public function __construct(private readonly ?LoggerInterface $logger = null) {}
    /** @var array<string,int> */
    private array $http = [
        'VIDEO_THUMBNAIL_INVALID_DIMENSIONS' => 422,
        'VIDEO_NOT_FOUND' => 404,
        'INTERNAL_SERVER_ERROR' => 500,
    ];

    /** @var array<string,int> */
    private array $cli = [
        'VIDEO_THUMBNAIL_INVALID_DIMENSIONS' => 2,
        'VIDEO_NOT_FOUND' => 3,
        'INTERNAL_SERVER_ERROR' => 1,
    ];

    /** @var array<string,int> */
    private array $grpc = [
        'VIDEO_THUMBNAIL_INVALID_DIMENSIONS' => 3, // INVALID_ARGUMENT
        'VIDEO_NOT_FOUND' => 5, // NOT_FOUND
        'INTERNAL_SERVER_ERROR' => 13, // INTERNAL
    ];

    public function httpStatus(ErrorCodeInterface $code): int
    {
        $rc = $code->responseCode();
        if (!array_key_exists($rc, $this->http)) {
            $this->logger?->warning('Unmapped ErrorCode for HTTP status', ['response_code' => $rc]);
        }
        return $this->http[$rc] ?? 500;
    }

    public function cliExitCode(ErrorCodeInterface $code): int
    {
        $rc = $code->responseCode();
        if (!array_key_exists($rc, $this->cli)) {
            $this->logger?->warning('Unmapped ErrorCode for CLI exit code', ['response_code' => $rc]);
        }
        return $this->cli[$rc] ?? 1;
    }

    public function grpcStatus(ErrorCodeInterface $code): int
    {
        $rc = $code->responseCode();
        if (!array_key_exists($rc, $this->grpc)) {
            $this->logger?->warning('Unmapped ErrorCode for gRPC status', ['response_code' => $rc]);
        }
        return $this->grpc[$rc] ?? 13; // INTERNAL
    }
}
