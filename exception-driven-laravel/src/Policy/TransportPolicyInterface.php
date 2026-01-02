<?php
declare(strict_types=1);

namespace ExceptionDriven\Policy;

use ExceptionDriven\ErrorHandling\ErrorCodeInterface;

interface TransportPolicyInterface
{
    /** Resolve all outcomes for a given error code. */
    public function outcome(ErrorCodeInterface $code): TransportOutcome;
}
