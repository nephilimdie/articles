<?php
declare(strict_types=1);

namespace ExceptionDriven\Presentation;

use ExceptionDriven\ErrorHandling\BoundaryErrorDto as ErrorDto;
use Symfony\Component\HttpFoundation\Response;

interface HttpErrorPresenterInterface extends ErrorPresenterInterface
{
    public function present(ErrorDto $dto): Response;
}

