<?php
namespace App\Http\Controllers\V1;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * CommentController class controlls all operations of comments.
 */

class CommentController extends Controller
{
    use RestActions;

    /**
     *  Create a new instance for AlbumController
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Create a new Comment
     *
     * @param Request $request - Request
     * @param int     $song_id - The id of the song.
     *
     * @return object Response object
     */
    public function create(Request $request, $song_id)
    {
        $this->validate($request, Comment::$rules);

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->song_id = $song_id;
        $comment->user_id = $request->user->id;
        $comment->save();

        return $this->respond(
            Response::HTTP_CREATED,
            ['message' => 'Comment added']
        );
    }

}