<?php
declare(strict_types=1);

namespace ExceptionDriven\ErrorHandling;

interface ErrorCodeInterface
{
    /**
     * Stable business identifier (API contract).
     */
    public function responseCode(): string;

    /**
     * Translation key used by the boundary.
     */
    public function translationKey(): string;

}
