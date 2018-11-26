<?php

namespace App\Http\Controllers\V1;

use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * AlbumController class controlls all operations of the ablum.
 *
 * This class holds creation, retrieving, updating and deleting of Albums in
 * the application.
 */

class AlbumController extends Controller
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
     * Create Album
     *
     * @param Request $request Request
     *
     * @return object Response object
     */
    public function create(Request $request)
    {
        $this->validate($request, Album::$rules);

        $album = new Album();
        $album->name = $request->name;
        $album->description = $request->description;
        $album->user_id = $request->user->id;

        if ($album->save()) {
            return $this->respond(
                Response::HTTP_CREATED,
                ['message' => 'Album created']
            );
        }
    }

    /**
     * Get all Albums for the current user.
     *
     * @param Request $request Request
     *
     * @return object Response object
     */
    public function getAlbums(Request $request)
    {
        $albums = User::find($request->user->id)->albums;
        return $this->respond(Response::HTTP_OK, $albums);
    }

    /**
     * Update Album
     *
     * @param Request $request  Request
     * @param int     $album_id Id of the album
     *
     * @return object Response object
     */
    public function update(Request $request, $album_id)
    {
        $album = Album::find($album_id);

        if (!$album) {
            return $this->respond(
                Response::HTTP_NOT_FOUND,
                ['message' => 'Album can\'t be found']
            );
        }

        $album->name = $request->name;
        $album->description = $request->description;
        $album->save();
        return $this->respond(Response::HTTP_OK, $album);
    }

    /**
     * Delete Album.
     *
     * @param Request $request  Request
     * @param int     $album_id Id of the album
     *
     * @return object Response object
     */
    public function delete(Request $request, $album_id)
    {
        $album = Album::find($album_id);

        if (!$album) {
            return $this->respond(
                Response::HTTP_NOT_FOUND,
                ['message' => 'Album can\'t be found']
            );
        }

        $album->delete();
        return $this->respond(
            Response::HTTP_NO_CONTENT,
            ['message' => 'Album deleted successfully']
        );
    }
}
