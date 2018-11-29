<?php

namespace App\Http\Controllers\V1;

use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Playlist;
use App\Models\PlaylistSong;

/**
 * Playlistcontroller class controlls all operations of a playlist.
 */

class PlaylistController extends Controller
{
    use RestActions;

    /**
     *  Create a new instance for PlaylistController
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Create Playlist
     *
     * @param Request $request Request
     *
     * @return object Response object
     */
    public function create(Request $request)
    {
        $this->validate($request, Playlist::$rules);

        $playlist = new Playlist();
        $playlist->name = $request->name;
        $playlist->description = $request->description;
        $playlist->user_id = $request->user->id;

        if ($playlist->save()) {
            return $this->respond(
                Response::HTTP_CREATED,
                ['message' => 'playlist created']
            );
        }
    }

    /**
     * Add Songs to Playlist
     *
     * @param Request $request     - Request
     * @param int     $playlist_id - The ID of the playlist
     * @param int     $song_id     - The ID of the song
     *
     * @return object Response object
     */
    public function addSong(Request $request, $playlist_id, $song_id)
    {
        $song = Song::find($song_id);
        $playlist = Playlist::findPlaylist($playlist_id, $request->user->id);

        if (empty($song) || empty($playlist)) {
            return $this->respond(
                Response::HTTP_NOT_FOUND,
                ['message' => 'Playlist|Song can\'t be found']
            );
        }

        $playlistSong = new PlaylistSong();
        $playlistSong->playlist_id = $playlist_id;
        $playlistSong->song_id = $song_id;

        if ($playlistSong->save()) {
            return $this->respond(
                Response::HTTP_CREATED,
                ['message' => 'Song add to playlist']
            );
        }
    }

    /**
     * Share Playlist
     *
     * @param Request $request     - Request
     * @param int     $playlist_id - The ID of the playlist
     *
     * @return object Response object
     */
    public function share(Request $request, $playlist_id)
    {
        $playlist = Playlist::findPlaylist($playlist_id, $request->user->id);

        if (empty($playlist)) {
            return $this->respond(
                Response::HTTP_NOT_FOUND,
                ['message' => 'Playlist can\'t be found']
            );
        }

        $songs = PlaylistSong::getPlaylistSongs($playlist_id);
        return $this->respond(
            Response::HTTP_OK,
            $songs
        );
    }
}
