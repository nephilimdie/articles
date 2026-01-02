<?php
declare(strict_types=1);

namespace ExceptionDriven\Presentation;

use ExceptionDriven\ErrorHandling\ErrorDto;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use ExceptionDriven\Policy\TransportPolicyInterface;

final class HttpErrorPresenter implements ErrorPresenterInterface
{
    public function present(ErrorDto $dto): Response
    {
        // Translation is a boundary service (framework i18n), not domain logic.
        $message = __($dto->messageKey, $dto->messageParams);

        $error = [
            'response_code' => $dto->responseCode(),
            'log_level' => $dto->logLevel,
            'message' => $message,
            'meta' => (object) $dto->meta,
            'error_id' => $dto->errorId,
        ];

        // Only error_id is returned.

        return new JsonResponse([
            'success' => false,
            'error' => $error,
        ], app(TransportPolicyInterface::class)->httpStatus($dto->code));
    }
}
