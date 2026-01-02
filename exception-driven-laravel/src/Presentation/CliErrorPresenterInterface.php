<?php
declare(strict_types=1);

namespace ExceptionDriven\Presentation;

use ExceptionDriven\ErrorHandling\BoundaryErrorDto as ErrorDto;

interface CliErrorPresenterInterface extends ErrorPresenterInterface
{
    /** @return int Exit code */
    public function present(ErrorDto $dto): int;
}

