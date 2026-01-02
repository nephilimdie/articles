<?php
declare(strict_types=1);

namespace ExceptionDriven\Exceptions;

use ExceptionDriven\ErrorHandling\ErrorAdapterInterface;
use ExceptionDriven\Presentation\ErrorPresenterRegistryInterface;
use ExceptionDriven\Presentation\Transport;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (Throwable $e, $request): Response {
            $correlationId =
                $request->headers->get('X-Request-ID')
                ?? $request->headers->get('X-Correlation-ID')
                ?? $request->headers->get('traceparent')
                ?? (string) Str::ulid();

            $dto = app(ErrorAdapterInterface::class)->toDto($e, (string) $correlationId);

            logger()->log($dto->logLevel, $e->getMessage(), $dto->toArray());

            $presenter = app(ErrorPresenterRegistryInterface::class)->resolveForHttp($request);
            return $presenter->present($dto);
        });
    }

    public function renderForConsole($output, Throwable $e): void
    {
        $correlationId =
            getenv('X_REQUEST_ID')
            ?: getenv('X_CORRELATION_ID')
            ?: getenv('TRACEPARENT')
            ?: (string) Str::ulid();

        $dto = app(ErrorAdapterInterface::class)->toDto($e, (string) $correlationId);

        logger()->log($dto->logLevel, $e->getMessage(), $dto->toArray());

        app(ErrorPresenterRegistryInterface::class)->get(Transport::CLI)->present($dto);
    }
}
