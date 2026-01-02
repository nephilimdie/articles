<?php
declare(strict_types=1);

namespace ExceptionDriven\Presentation;

use ExceptionDriven\ErrorHandling\BoundaryErrorDto as ErrorDto;
use ExceptionDriven\Policy\TransportPolicyInterface;

final class GrpcErrorPresenter implements ErrorPresenterInterface
{
    /**
     * Example return type: an array describing gRPC status + metadata.
     * A real implementation would return/throw the library-specific status object.
     *
     * @return array{status:int,message:string,metadata:array<string,string>}
     */
    public function present(ErrorDto $dto): array
    {
        return [
            'status' => app(TransportPolicyInterface::class)->grpcStatus($dto->code),
            // Translation is a boundary service (framework i18n), not domain logic.
            'message' => __($dto->messageKey, $dto->messageParams),
            'metadata' => [
                'response_code' => $dto->responseCode(),
                'log_level' => $dto->logLevel,
                'correlation_id' => $dto->correlationId,
            ],
        ];
    }
}
