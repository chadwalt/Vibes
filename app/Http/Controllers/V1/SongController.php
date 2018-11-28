<?php

namespace App\Http\Controllers\V1;

use App\Models\Song;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * SongController class controlls all operations of the songs.
 */

class SongController extends Controller
{
    use RestActions;
    use FileTrait;

    /**
     *  Create a new instance for AlbumController
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
        $this->middleware('role:artiste', ['only' => 'create']);
    }

    /**
     * Create Song
     *
     * @param Request $request  Request
     * @param int     $album_id The id of album.
     *
     * @return object Response object
     */
    public function create(Request $request, $album_id)
    {
        $this->validate($request, Song::$rules);

        if ($request->song->getClientOriginalExtension() !== 'mp3' || empty($this->uploadFile($request->song))) {
            return $this->respond(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                ['message' => 'Please provide a valid file']
            );
        }

        $song = new Song();
        $song->name = $request->name;
        $song->description = $request->description;
        $song->album_id = $album_id;
        $song->url = $this->uploadFile($request->song);
        $song->save();

        return $this->respond(
            Response::HTTP_CREATED,
            ['message' => 'song created']
        );
    }
}
