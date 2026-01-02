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
use ExceptionDriven\Policy\TransportPolicyInterface;
use ExceptionDriven\Policy\PlatformTransportPolicyProvider;
use ExceptionDriven\Policy\TransportPolicyRegistry;
use ExceptionDriven\Domain\Video\Policy\VideoTransportPolicyProvider;
use ExceptionDriven\Domain\User\Policy\UserTransportPolicyProvider;
use Illuminate\Support\ServiceProvider;

final class ErrorHandlingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ErrorAdapterInterface::class, DefaultErrorAdapter::class);

        // Transport policy registry with domain providers and platform fallback
        $this->app->singleton(VideoTransportPolicyProvider::class);
        $this->app->singleton(PlatformTransportPolicyProvider::class);
        $this->app->singleton(UserTransportPolicyProvider::class);

        $this->app->singleton(TransportPolicyInterface::class, function ($app) {
            return new TransportPolicyRegistry(
                providers: [
                    $app->make(VideoTransportPolicyProvider::class),
                    $app->make(UserTransportPolicyProvider::class),
                    // register more domain providers here (Billing, ...)
                ],
                fallback: $app->make(PlatformTransportPolicyProvider::class),
            );
        });

        $this->app->singleton(HttpErrorPresenter::class);
        $this->app->singleton(HtmlErrorPresenter::class);
        $this->app->singleton(CliErrorPresenter::class);
        $this->app->singleton(GrpcErrorPresenter::class);
        $this->app->singleton(ErrorPresenterRegistryInterface::class, DefaultErrorPresenterRegistry::class);
    }
}
