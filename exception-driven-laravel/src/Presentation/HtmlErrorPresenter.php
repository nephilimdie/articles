<?php
declare(strict_types=1);

namespace ExceptionDriven\Presentation;

use ExceptionDriven\ErrorHandling\ErrorDto;
use ExceptionDriven\Policy\TransportPolicyInterface;
use Illuminate\Http\Response;

final class HtmlErrorPresenter implements ErrorPresenterInterface
{
    public function present(ErrorDto $dto): Response
    {
        // Translation is a boundary service (framework i18n), not domain logic.
        $message = __($dto->messageKey, $dto->messageParams);

        return response()->view('errors.generic', [
            'response_code' => $dto->responseCode(),
            'message' => $message,
            'meta' => $dto->meta,
            'error_id' => $dto->errorId,
        ], app(TransportPolicyInterface::class)->httpStatus($dto->code));
    }
}
