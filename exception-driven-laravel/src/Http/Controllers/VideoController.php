<?php
declare(strict_types=1);

namespace ExceptionDriven\Http\Controllers;

use ExceptionDriven\Domain\Video\VideoGuards;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class VideoController
{
    public function uploadThumbnail(Request $request): JsonResponse
    {
        $width = (int) $request->input('width');
        $height = (int) $request->input('height');

        VideoGuards::thumbnailIsLargeEnough($width, $height);

        return response()->json(['success' => true]);
    }
}
