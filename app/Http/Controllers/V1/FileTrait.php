<?php
namespace App\Http\Controllers\V1;

use Illuminate\Support\Facades\Storage;

/**
 * Handles File uploads, downloads.
 */
trait FileTrait
{
    /**
     * Response Headers
     *
     * @var array headers
     */
    protected $responseHeaders = [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
        'Access-Control-Allow-Credentials' => 'true',
        'Access-Control-Max-Age' => '86400',
        'Access-Control-Allow-Headers' =>
            'Content-Type, Authorization, X-Requested-With',
    ];

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

    /**
     * Return file path.
     *
     * @param file $file the file details
     *
     * @return pathname
     */
    public function getFilePath($file)
    {
        if (empty($file)) {
            return null;
        }

        $path = Storage::url($file->url);
        return $path;
    }

    /**
     * Download file.
     *
     * @param string $file     the file to download
     * @param string $filename the user will see this name when downloading the file.
     * @param array  $headers  the response headers
     *
     * @return mixed
     */
    public function downloadFile($file, $filename = '', $headers = [])
    {
        if (empty($headers)) {
            $headers = $this->responseHeaders;
        }

        if (empty($file)) {
            return null;
        }

        return Storage::download($file, $filename, $headers);
    }

    /**
     * Delete file.
     *
     * @param string $file the file to delete
     *
     * @return mixed
     */
    public function deleteFile($file)
    {
        if (empty($file)) {
            return null;
        }

        return Storage::delete($file);
    }
}