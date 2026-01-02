<?php
declare(strict_types=1);

namespace ExceptionDriven\Presentation;
use Illuminate\Http\Request;

/**
 * Registry/resolver for error presenters across transports.
 */
interface ErrorPresenterRegistryInterface
{
    /**
     * Resolve the appropriate HTTP presenter (JSON/HTML) by inspecting the request.
     */
    public function resolveForHttp(Request $request): HttpErrorPresenterInterface;

    /**
     * Return the presenter registered for a given transport.
     *
     * @return object One of: HttpErrorPresenter|HtmlErrorPresenter|CliErrorPresenter|GrpcErrorPresenter
     */
    public function get(Transport $transport): ErrorPresenterInterface;
}
