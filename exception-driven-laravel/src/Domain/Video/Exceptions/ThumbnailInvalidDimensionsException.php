<?php
declare(strict_types=1);

namespace ExceptionDriven\Domain\Video\Exceptions;

use ExceptionDriven\Domain\Video\VideoErrorCode;
use ExceptionDriven\ErrorHandling\ErrorCodeInterface;
use ExceptionDriven\Exceptions\ApiException;
use Psr\Log\LogLevel;

final class ThumbnailInvalidDimensionsException extends ApiException
{
    public const LOG_LEVEL = LogLevel::INFO;

    public function __construct(
        private int $width,
        private int $height
    ) {
        parent::__construct();
    }

    public static function code(): ErrorCodeInterface
    {
        return VideoErrorCode::THUMBNAIL_INVALID_DIMENSIONS;
    }

    public function publicMeta(): array
    {
        return ['width' => $this->width, 'height' => $this->height];
    }

    public function category(): string
    {
        return 'validation';
    }

    public function isExpected(): bool
    {
        return true;
    }
}
