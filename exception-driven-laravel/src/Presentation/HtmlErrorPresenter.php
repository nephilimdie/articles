<?php
declare(strict_types=1);

namespace ExceptionDriven\Presentation;

use ExceptionDriven\ErrorHandling\BoundaryErrorDto as ErrorDto;
use ExceptionDriven\Policy\TransportPolicyInterface;
use Illuminate\Http\Response;

final class HtmlErrorPresenter implements HtmlErrorPresenterInterface
{
    public function present(ErrorDto $dto): Response
    {
        // Translation is a boundary service (framework i18n), not domain logic.
        $message = __($dto->messageKey, $dto->messageParams);

        return response()->view('errors.generic', [
            'response_code' => $dto->responseCode(),
            'message' => $message,
            'meta' => $dto->meta,
            'correlation_id' => $dto->correlationId,
        ], app(TransportPolicyInterface::class)->outcome($dto->code)->httpStatus);
    }
}
