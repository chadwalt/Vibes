<?php
namespace Tests\App\Http\Controller\V1;

use TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\V1\FileTrait;


/**
 * Test FileTrait
 */
class FileTraitTest extends TestCase
{
    use FileTrait;

    /**
     * Test successful upload of a file.
     *
     * @return void
     */
    public function testFileUploadSuccess()
    {
        $file = UploadedFile::fake()->create('mama.mp3');
        $this->assertEquals('audio/mama.mp3', $this->uploadFile($file));
    }

    // /**
    //  * Test invalid file upload.
    //  *
    //  * @return void
    //  */
    // public function testInvalidFileUpload()
    // {
    //     $file = UploadedFile::fake()->create('mama.mp3', 50000);
    //     $this->assertEquals(null, $this->uploadFile($file));
    // }

    /**
     * Test failure on getting file path
     *
     * @return void
     */
    public function testGettingFilePathFailure()
    {
        $this->assertEquals(null, $this->getFilePath(null));
    }

    /**
     * Test getting file path
     *
     * @return void
     */
    public function testGettingFilePathSuccess()
    {
        $file = UploadedFile::fake()->create('mama.mp3');
        $file->url = 'audio/mama.mp3';
        $this->assertEquals('/storage/audio/mama.mp3', $this->getFilePath($file));
    }

    /**
     * Test downloading file failure
     *
     * @return void
     */
    public function testDownloadFileFailure()
    {
        $this->assertEquals(null, $this->downloadFile(''));
    }

    /**
     * Test deleting file failure
     *
     * @return void
     */
    public function testdeleteFileFailure()
    {
        $this->assertEquals(null, $this->deleteFile(''));
    }
}