<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadHelper
{

    public static function UploadImage(UploadedFile $uploadedFile, $diskName = null)
    {
        $disk = $diskName ?? env('FILESYSTEM_DISK');
        $path = $uploadedFile->store('images', $disk);
        Storage::disk($disk)->setVisibility($path, 'public');
        $url = Storage::disk($disk)->url($path);
        return [
            'path' => $path,
            'url' => $url,
        ];
    }

}
