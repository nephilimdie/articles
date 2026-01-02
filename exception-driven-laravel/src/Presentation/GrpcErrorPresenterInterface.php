<?php
declare(strict_types=1);

namespace ExceptionDriven\Presentation;

use ExceptionDriven\ErrorHandling\BoundaryErrorDto as ErrorDto;

interface GrpcErrorPresenterInterface extends ErrorPresenterInterface
{
    /**
     * @return array{status:int,message:string,metadata:array<string,string>}
     */
    public function present(ErrorDto $dto): array;
}

