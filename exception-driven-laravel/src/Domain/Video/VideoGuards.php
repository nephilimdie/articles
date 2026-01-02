<?php
declare(strict_types=1);

namespace ExceptionDriven\Domain\Video;

use ExceptionDriven\Domain\Video\Exceptions\ThumbnailInvalidDimensionsException;

final class VideoGuards
{
    public static function thumbnailIsLargeEnough(int $width, int $height): void
    {
        if ($width < 640 || $height < 360) {
            throw new ThumbnailInvalidDimensionsException($width, $height);
        }
    }
}
