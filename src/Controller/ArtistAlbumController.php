<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ArtistAlbumController
{
    /**
     * @Route("/artists/{artist}", methods="GET", name="artist_albums")
     */
    public function albums($artist)
    {

        return new JsonResponse([
            'artist' => $artist,
            'albums' => [],
        ]);
    }
}