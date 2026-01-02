<?php
declare(strict_types=1);

namespace ExceptionDriven\Presentation;

use ExceptionDriven\ErrorHandling\BoundaryErrorDto as ErrorDto;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use ExceptionDriven\Policy\TransportPolicyInterface;

final class HttpErrorPresenter implements ErrorPresenterInterface, HttpErrorPresenterInterface
{
    public function present(ErrorDto $dto): Response
    {
        // Translation is a boundary service (framework i18n), not domain logic.
        $message = __($dto->messageKey, $dto->messageParams);

        $meta = $dto->meta;
        $isList = array_keys($meta) === range(0, count($meta) - 1);
        $metaPayload = $isList ? ['data' => $meta] : $meta;

        $error = [
            'response_code' => $dto->responseCode(),
            'log_level' => $dto->logLevel,
            'message' => $message,
            'meta' => (object) $metaPayload,
            'correlation_id' => $dto->correlationId,
        ];

        // Only correlation_id is returned.

        return new JsonResponse([
            'success' => false,
            'error' => $error,
        ], app(TransportPolicyInterface::class)->outcome($dto->code)->httpStatus);
    }
}
