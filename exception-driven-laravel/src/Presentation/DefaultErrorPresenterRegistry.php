<?php
declare(strict_types=1);

namespace ExceptionDriven\Presentation;

use Illuminate\Http\Request;

final class DefaultErrorPresenterRegistry implements ErrorPresenterRegistryInterface
{
    public function __construct(
        private readonly HttpErrorPresenter $http,
        private readonly HtmlErrorPresenter $html,
        private readonly CliErrorPresenter $cli,
        private readonly GrpcErrorPresenter $grpc,
    ) {}

    public function resolveForHttp(Request $request): HttpErrorPresenterInterface
    {
        $accept = (string) $request->headers->get('Accept', '');
        if (stripos($accept, 'application/json') !== false) {
            return $this->http;
        }
        if (stripos($accept, 'text/html') !== false) {
            return $this->html;
        }
        return $request->expectsJson() ? $this->http : $this->html;
    }

    public function get(Transport $transport): ErrorPresenterInterface
    {
        return match ($transport) {
            Transport::HTTP_JSON => $this->http,
            Transport::HTTP_HTML => $this->html,
            Transport::CLI => $this->cli,
            Transport::GRPC => $this->grpc,
        };
    }
}
