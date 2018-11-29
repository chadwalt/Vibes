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
        $this->middleware('role:artiste', ['only' => ['create', 'delete']]);
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
        $song->genre = $request->genre;
        $song->album_id = $album_id;
        $song->url = $this->uploadFile($request->song);
        $song->save();

        return $this->respond(
            Response::HTTP_CREATED,
            ['message' => 'song created']
        );
    }

    /**
     * Download Song
     *
     * @param Request $request Request
     * @param int     $song_id The id of the song.
     *
     * @return object Response object
     */
    public function download(Request $request, $song_id)
    {
        $song = Song::find($song_id);

        if (empty($song)) {
            return $this->respond(
                Response::HTTP_NOT_FOUND,
                ['message' => 'Song can\'t be found']
            );
        }

        return $this->downloadFile($song->url, $song->name);
    }

    /**
     * Delete Song
     *
     * @param Request $request Request
     * @param int     $song_id The id of the song.
     *
     * @return object Response object
     */
    public function delete(Request $request, $song_id)
    {
        $song = Song::find($song_id);

        if (empty($song)) {
            return $this->respond(
                Response::HTTP_NOT_FOUND,
                ['message' => 'Song can\'t be found']
            );
        }

        $this->deleteFile($song->url);
        return $this->respond(Response::HTTP_NO_CONTENT);
    }

    /**
     * Return all Songs
     *
     * @param Request $request Request
     *
     * @return object Response object
     */
    public function getSongs(Request $request)
    {
        $songs = Song::getSongs();
        return $this->respond(Response::HTTP_OK, $songs);
    }

    /**
     * Search through songs
     *
     * @param Request $request Request
     *
     * @return object Response object
     */
    public function search(Request $request)
    {
        $songs = Song::searchSong($request->q);
        return $this->respond(Response::HTTP_OK, $songs);
    }
}
