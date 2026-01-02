<?php
declare(strict_types=1);

namespace ExceptionDriven\Presentation;

use ExceptionDriven\ErrorHandling\ErrorDto;
use ExceptionDriven\Policy\TransportPolicyInterface;

final class CliErrorPresenter
{
    /**
     * @return int Exit code
     */
    public function present(ErrorDto $dto): int
    {
        // Translation is a boundary service (framework i18n), not domain logic.
        $message = __($dto->messageKey, $dto->messageParams);

        fwrite(STDERR, sprintf("%s: %s\n", $dto->responseCode(), $message));
        fwrite(STDERR, sprintf("error_id: %s\n", $dto->errorId));

        if (!empty($dto->meta)) {
            fwrite(STDERR, json_encode(['meta' => $dto->meta], JSON_UNESCAPED_SLASHES) . "\n");
        }

        return app(TransportPolicyInterface::class)->cliExitCode($dto->code);
    }
}
