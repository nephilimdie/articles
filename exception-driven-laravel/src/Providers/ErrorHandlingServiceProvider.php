<?php
declare(strict_types=1);

namespace ExceptionDriven\Providers;

use ExceptionDriven\ErrorHandling\DefaultErrorAdapter;
use ExceptionDriven\ErrorHandling\ErrorAdapterInterface;
use ExceptionDriven\Presentation\DefaultErrorPresenterRegistry;
use ExceptionDriven\Presentation\ErrorPresenterRegistryInterface;
use ExceptionDriven\Presentation\CliErrorPresenter;
use ExceptionDriven\Presentation\GrpcErrorPresenter;
use ExceptionDriven\Presentation\HttpErrorPresenter;
use ExceptionDriven\Presentation\HtmlErrorPresenter;
use ExceptionDriven\Policy\DefaultTransportPolicy;
use ExceptionDriven\Policy\TransportPolicyInterface;
use Illuminate\Support\ServiceProvider;

final class ErrorHandlingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ErrorAdapterInterface::class, DefaultErrorAdapter::class);
        $this->app->singleton(TransportPolicyInterface::class, DefaultTransportPolicy::class);
        $this->app->singleton(HttpErrorPresenter::class);
        $this->app->singleton(HtmlErrorPresenter::class);
        $this->app->singleton(CliErrorPresenter::class);
        $this->app->singleton(GrpcErrorPresenter::class);
        $this->app->singleton(ErrorPresenterRegistryInterface::class, DefaultErrorPresenterRegistry::class);
    }
}
