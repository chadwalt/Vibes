<?php
namespace Tests\App\Http\Controller\V1;

use TestCase;

/**
 * Test SongController file.
 */
class CommentControllerTest extends TestCase
{
    /**
     * File test details.
     *
     * @var array
     */
    private $_commentData = [
        'comment' => 'This is happening',
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
        factory(\App\Models\Album::class)->create();
        factory(\App\Models\Song::class)->create();
        $this->_token = $this->generateToken($user);
    }

    /**
     * Test successful creation of comment
     *
     * @return void
     */
    public function testSuccessfullCommentCreation()
    {
        $this->post(
            'api/v1/song/1/comment',
            $this->_commentData,
            ['api-token' => $this->_token]
        );

        $this->seeStatusCode(201);
        $this->seeInDatabase(
            'comments',
            ['comment' => 'This is happening']
        );
    }

    /**
     * Test failure creation of comment
     *
     * @return void
     */
    public function testfailurelCommentCreation()
    {
        $this->_commentData['comment'] = 'now';
        $this->post(
            'api/v1/song/1/comment',
            $this->_commentData,
            ['api-token' => $this->_token]
        );
        $this->seeStatusCode(422);
        $this->missingFromDatabase(
            'comments',
            ['comment' => 'This is happening']
        );
        $content = json_decode($this->response->getContent());
        $this->assertEquals(
            'The comment must be at least 10 characters.',
            $content->comment[0]
        );
    }
}
