<?php
declare(strict_types=1);

namespace ExceptionDriven\Policy;

final class TransportOutcome
{
    public function __construct(
        public readonly int $httpStatus,
        public readonly int $cliExitCode,
        public readonly GrpcStatus $grpcStatus,
    ) {}
}
