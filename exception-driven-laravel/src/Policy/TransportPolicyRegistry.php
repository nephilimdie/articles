<?php
declare(strict_types=1);

namespace ExceptionDriven\Policy;

use ExceptionDriven\ErrorHandling\ErrorCodeInterface;

final class TransportPolicyRegistry implements TransportPolicyInterface
{
    /** @param list<TransportPolicyProviderInterface> $providers */
    public function __construct(
        private readonly array $providers,
        private readonly TransportPolicyProviderInterface $fallback,
    ) {}

    public function outcome(ErrorCodeInterface $code): TransportOutcome
    {
        foreach ($this->providers as $provider) {
            if ($provider->supports($code)) {
                return $provider->outcome($code);
            }
        }

        return $this->fallback->outcome($code);
    }
}

