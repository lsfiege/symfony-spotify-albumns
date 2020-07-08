<?php

namespace App\Services;

use App\Clients\Spotify\Client;
use App\Exceptions\ArtistNotFoundException;

class SpotifyService
{
    private $client;

    private $artists;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param $artist
     *
     * @return array
     *
     * @throws ArtistNotFoundException
     */
    public function searchArtist($artist)
    {
        $data = $this->client->searchArtist($artist);

        if (empty($data->artists->items)) {
            throw new ArtistNotFoundException();
        }

        $this->artists = $data->artists->items;

        return $this->artists[0];
    }

    /**
     * @param $artistID
     *
     * @return array
     */
    public function searchArtistAlbums($artistID)
    {
        $data = $this->client->searchArtistAlbums($artistID);

        return $data->items;
    }
}