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
use ExceptionDriven\Presentation\CliErrorPresenter;

final class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (Throwable $e, $request): Response {
            $errorId =
                $request->headers->get('X-Request-ID')
                ?? $request->headers->get('X-Correlation-ID')
                ?? $request->headers->get('traceparent')
                ?? (string) Str::ulid();

            $dto = app(ErrorAdapterInterface::class)->toDto($e, (string) $errorId);

            $context = $dto->logContext;
            $context['exception'] = $e;
            logger()->log($dto->logLevel, $e->getMessage(), $context);

            $presenter = app(ErrorPresenterRegistryInterface::class)->resolveForHttp($request);
            return $presenter->present($dto);
        });
    }

    public function renderForConsole($output, Throwable $e): void
    {
        $errorId =
            getenv('X_REQUEST_ID')
            ?: getenv('X_CORRELATION_ID')
            ?: getenv('TRACEPARENT')
            ?: (string) Str::ulid();

        $dto = app(ErrorAdapterInterface::class)->toDto($e, (string) $errorId);

        $context = $dto->logContext;
        $context['exception'] = $e;
        logger()->log($dto->logLevel, $e->getMessage(), $context);

        /** @var \ExceptionDriven\Presentation\CliErrorPresenter $cli */
        $cli = app(ErrorPresenterRegistryInterface::class)->get(Transport::CLI);
        $cli->present($dto);
    }
}
