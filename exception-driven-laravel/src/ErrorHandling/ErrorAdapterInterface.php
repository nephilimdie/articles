<?php
declare(strict_types=1);

namespace ExceptionDriven\ErrorHandling;

use Throwable;

interface ErrorAdapterInterface
{
    public function toDto(Throwable $throwable, string $correlationId): BoundaryErrorDto;
}
