<?php

namespace App\Clients\Spotify;

use Carbon\Carbon;

class Authenticator
{
    private $authURL = 'https://accounts.spotify.com';

    private $token;

    private $tokenExpiration;

    private function getEncodedCredentials()
    {
        $clientID = $_SERVER['SPOTIFY_CLIENT_ID'];

        $clientSecret = $_SERVER['SPOTIFY_CLIENT_SECRET'];

        return base64_encode("{$clientID}:{$clientSecret}");
    }

    private function getNewTokenExpiration()
    {
        return Carbon::now()->addSeconds($this->token->expires_in);
    }

    public function getToken()
    {
        if ($this->tokenHasExpired()) {
            $this->getValidToken();
        }

        return $this->token->access_token;
    }

    public function getValidToken()
    {
        $credentials = $this->getEncodedCredentials();

        $authenticator = new \GuzzleHttp\Client(['base_uri' => $this->authURL]);

        $response = $authenticator->request('POST', '/api/token', [
            'headers' => [
                'Authorization' => "Basic {$credentials}",
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        $this->token = json_decode($response->getBody()->getContents());

        $this->tokenExpiration = $this->getNewTokenExpiration();
    }

    public function tokenHasExpired()
    {
        if (is_null($this->token)) {
            return true;
        }

        $now = Carbon::now();

        if ($now->isAfter($this->tokenExpiration)) {
            return true;
        }

        return false;
    }
}