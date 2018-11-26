<?php
namespace Tests\App\Http\Controller\V1;

use TestCase;

/**
 * Test UserControllerTest file.
 */
class AlbumControllerTest extends TestCase
{
    /**
     * Sign-up User test details.
     *
     * @var array
     */
    private $_albumData = [
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

        $user = factory(\App\Models\User::class)->create();
        $this->_token = $this->generateToken($user);
    }

    /**
     * Test successful creation of a new Album.
     *
     * @return void
     */
    public function testAlbumCreationSuccess()
    {
        $response = $this->post(
            'api/v1/album/', $this->_albumData, ['api-token' => $this->_token]
        );
        $this->seeStatusCode(201);
        $this->seeInDatabase(
            'albums', [ 'name' => 'Jesus Walks']
        );
    }

    /**
     * Test validation of album data.
     *
     * @return void
     */
    public function testInvalidAlbumDetailsFailure()
    {
        $this->_albumData['name'] = '';
        $this->post(
            'api/v1/album/', $this->_albumData, ['api-token' => $this->_token]
        );
        $content = json_decode($this->response->getContent());
        $this->seeStatusCode(422);
        $this->assertEquals('The name field is required.', $content->name[0]);
    }

    /**
     * Test retrieval of all albums
     *
     * @return void
     */
    public function testGetAllAlbumsSuccess()
    {
        factory(\App\Models\Album::class)->create();

        $this->get(
            'api/v1/album/', ['api-token' => $this->_token]
        );

        $content = json_decode($this->response->getContent());
        $this->seeStatusCode(200);
        $this->assertEquals(1, count($content));
    }

    /**
     * Test updating of album successfully
     *
     * @return void
     */
    public function testUpdateAlbumSuccess()
    {
        factory(\App\Models\Album::class)->create();

        $this->_albumData['name'] = 'Love is kind';
        $this->patch(
            'api/v1/album/1', $this->_albumData, ['api-token' => $this->_token]
        );

        $content = json_decode($this->response->getContent());
        $this->seeStatusCode(200);
        $this->assertEquals('Love is kind', $content->name);
        $this->seeInDatabase(
            'albums', [ 'name' => 'Love is kind']
        );
    }

    /**
     * Test updating of album that doesn't exist
     *
     * @return void
     */
    public function testUpdateAlbumFailure()
    {
        factory(\App\Models\Album::class)->create();

        $this->_albumData['name'] = 'Love is kind';
        $this->patch(
            'api/v1/album/12', $this->_albumData, ['api-token' => $this->_token]
        );

        $content = json_decode($this->response->getContent());
        $this->seeStatusCode(404);
        $this->assertEquals('Album can\'t be found', $content->message);
    }

    /**
     * Test deleting an album successfully
     *
     * @return void
     */
    public function testDeleteAlbumSuccess()
    {
        factory(\App\Models\Album::class)->create();

        $this->_albumData['name'] = 'Love is kind';
        $this->delete(
            'api/v1/album/1', $data = [], ['api-token' => $this->_token]
        );

        $content = json_decode($this->response->getContent());
        $this->seeStatusCode(204);
    }

    /**
     * Test deleteing an album that doesn't exist
     *
     * @return void
     */
    public function testDeleteAlbumFailure()
    {
        factory(\App\Models\Album::class)->create();

        $this->_albumData['name'] = 'Love is kind';
        $this->delete(
            'api/v1/album/12', $data = [], ['api-token' => $this->_token]
        );

        $content = json_decode($this->response->getContent());
        $this->seeStatusCode(404);
        $this->assertEquals('Album can\'t be found', $content->message);
    }
}
