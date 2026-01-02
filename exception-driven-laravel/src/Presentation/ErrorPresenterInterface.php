<?php
declare(strict_types=1);

namespace ExceptionDriven\Presentation;

use ExceptionDriven\ErrorHandling\ErrorDto;
use Symfony\Component\HttpFoundation\Response;

interface ErrorPresenterInterface
{
    public function present(ErrorDto $dto): Response;
}

