<?php

namespace App\Clients\Spotify;

class Client
{
    private $baseURL = 'https://api.spotify.com';

    private $version = 'v1';

    private $broker;

    private $token;

    private $client;

    public function __construct()
    {
        $this->broker = new Authenticator();

        $this->token = $this->broker->getToken();

        $this->client = new \GuzzleHttp\Client(['base_uri' => $this->baseURL]);
    }

    public function searchArtist($artist)
    {
        $response = $this->client->get("/{$this->version}/search?q={$artist}&type=artist", [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer {$this->token}",
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function searchArtistAlbums($artistID)
    {
        $response = $this->client->get("/{$this->version}/artists/{$artistID}/albums", [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer {$this->token}",
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }
}