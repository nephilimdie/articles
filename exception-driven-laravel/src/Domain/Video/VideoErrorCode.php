<?php
declare(strict_types=1);

namespace ExceptionDriven\Domain\Video;

use ExceptionDriven\ErrorHandling\ErrorCodeInterface;

enum VideoErrorCode: string implements ErrorCodeInterface
{
    case THUMBNAIL_INVALID_DIMENSIONS = 'VIDEO_THUMBNAIL_INVALID_DIMENSIONS';
    case VIDEO_NOT_FOUND = 'VIDEO_NOT_FOUND';

    public function responseCode(): string
    {
        return $this->value;
    }

    public function translationKey(): string
    {
        return match ($this) {
            self::THUMBNAIL_INVALID_DIMENSIONS => 'errors.video.thumbnail_invalid_dimensions',
            self::VIDEO_NOT_FOUND => 'errors.video.not_found',
        };
    }
}
