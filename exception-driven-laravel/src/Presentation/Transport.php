<?php
declare(strict_types=1);

namespace ExceptionDriven\Presentation;

enum Transport: string
{
    case HTTP_JSON = 'http_json';
    case HTTP_HTML = 'http_html';
    case CLI = 'cli';
    case GRPC = 'grpc';
}

