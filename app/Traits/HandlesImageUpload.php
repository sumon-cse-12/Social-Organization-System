<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HandlesImageUpload
{
    /**
     * Store uploaded image and return path.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param bool $deleteOld
     * @param string|null $oldFile
     * @return string
     */
    public function uploadImage(UploadedFile $file, string $folder = 'uploads', bool $deleteOld = false, ?string $oldFile = null): string
    {

        if ($deleteOld && $oldFile) {
            Storage::disk('public')->delete($oldFile);
        }

        $filename = time() . '.' . $file->getClientOriginalExtension();

        return $file->storeAs($folder, $filename, 'public');
    }
}
