<?php
declare(strict_types=1);

namespace ExceptionDriven\Policy;

use ExceptionDriven\ErrorHandling\ErrorCodeInterface;

interface TransportPolicyProviderInterface
{
    /** Whether this provider owns/matches the given code (usually by enum class). */
    public function supports(ErrorCodeInterface $code): bool;

    /** Resolve transport outcomes for a code owned by this provider. */
    public function outcome(ErrorCodeInterface $code): TransportOutcome;
}

