<?php
declare(strict_types=1);

namespace ExceptionDriven\Presentation;

use ExceptionDriven\ErrorHandling\BoundaryErrorDto as ErrorDto;
use Illuminate\Http\Response;

interface HtmlErrorPresenterInterface extends ErrorPresenterInterface
{
    public function present(ErrorDto $dto): Response;
}

