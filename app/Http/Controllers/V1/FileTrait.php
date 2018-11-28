<?php
namespace App\Http\Controllers\V1;

/**
 * Handles File uploads, downloads.
 */
trait FileTrait
{
    /**
     * Upload files to the store/audio directory.
     *
     * @param file $file the file to upload
     *
     * @return mixed
     */
    public function uploadFile($file)
    {
        if (!$file->isValid()) {
            return null;
        }

        $filename = $file->getClientOriginalName();
        $path = $file->storeAs('audio', $filename);

        return $path;
    }
}