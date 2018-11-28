<?php
namespace Tests\App\Http\Controller\V1;

use TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Test SongController file.
 */
class SongControllerTest extends TestCase
{
    /**
     * File test details.
     *
     * @var array
     */
    private $_songData = [
        'name' => 'Jesus Walks',
        'description' => 'Walks in my life',
    ];

    /**
     * Json Web Token.
     *
     * @var string
     */
    private $_token = null;

    /**
     * Setup before each test
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $user = factory(\App\Models\User::class)->create(['role' => 'artiste']);
        factory(\App\Models\Album::class)->create();
        $this->_token = $this->generateToken($user);
    }

    /**
     * Test fail upload success
     *
     * @return void
     */
    public function testFileUploadSuccess()
    {
        Storage::fake('audio/mama.mp3');

        $this->_songData['song'] = UploadedFile::fake()->create('mama.mp3');

        $this->post(
            'api/v1/song/album/1', $this->_songData, ['api-token' => $this->_token]
        );
        $this->seeStatusCode(201);
        $this->seeInDatabase(
            'songs', [ 'name' => 'Jesus Walks']
        );
    }

    /**
     * Test fail upload failure
     *
     * @return void
     */
    public function testFileUploadFailure()
    {
        Storage::fake('audio/mama.mp3');

        $this->_songData['song'] = UploadedFile::fake()->create('mama.pdf');

        $this->post(
            'api/v1/song/album/1', $this->_songData, ['api-token' => $this->_token]
        );
        $this->seeStatusCode(422);
        $this->missingFromDatabase(
            'songs', [ 'name' => 'Jesus Walks']
        );
    }
}