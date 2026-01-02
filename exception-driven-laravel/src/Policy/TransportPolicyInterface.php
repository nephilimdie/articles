<?php
declare(strict_types=1);

namespace ExceptionDriven\Policy;

use ExceptionDriven\ErrorHandling\ErrorCodeInterface;

interface TransportPolicyInterface
{
    public function httpStatus(ErrorCodeInterface $code): int;
    public function cliExitCode(ErrorCodeInterface $code): int;
    public function grpcStatus(ErrorCodeInterface $code): int;
}

