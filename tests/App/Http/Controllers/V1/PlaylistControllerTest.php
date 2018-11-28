<?php
namespace Tests\App\Http\Controller\V1;

use TestCase;

/**
 * Test PlaylistController file.
 */
class PlaylistControllerTest extends TestCase
{
    /**
     * Playlist test details.
     *
     * @var array
     */
    private $_playlistData = [
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
        $this->_token = $this->generateToken($user);
    }

    /**
     * Test successful creation of a new Playlist.
     *
     * @return void
     */
    public function testplaylistCreationSuccess()
    {
        $this->post(
            'api/v1/playlist', $this->_playlistData, ['api-token' => $this->_token]
        );
        $this->seeStatusCode(201);
        $this->seeInDatabase(
            'playlists', [ 'name' => 'Jesus Walks']
        );
    }

    /**
     * Test validation of playlist data.
     *
     * @return void
     */
    public function testInvalidplaylistDetailsFailure()
    {
        $this->_playlistData['name'] = '';
        $this->post(
            'api/v1/playlist/', $this->_playlistData, ['api-token' => $this->_token]
        );
        $content = json_decode($this->response->getContent());
        $this->seeStatusCode(422);
        $this->assertEquals('The name field is required.', $content->name[0]);
    }
}
