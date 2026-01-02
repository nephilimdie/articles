<?php
declare(strict_types=1);

namespace ExceptionDriven\Presentation;

use ExceptionDriven\ErrorHandling\BoundaryErrorDto as ErrorDto;

interface ErrorPresenterInterface
{
    /**
     * Present the error to the current transport.
     *
     * @return mixed Response|int|array depending on transport
     */
    public function present(ErrorDto $dto): mixed;
}
