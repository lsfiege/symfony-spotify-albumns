<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Services\SpotifyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ArtistAlbumController extends AbstractController
{
    /** @var SpotifyService */
    private $service;

    public function __construct(SpotifyService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/artists/{name}", methods="GET", name="artist_albums")
     */
    public function albums($name, ValidatorInterface $validator)
    {
        $artist = new Artist($name);

        $errors = $validator->validate($artist);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return $this->json([
                'error' => $errorsString,
            ]);
        }

        try {
            $artist = $this->service->searchArtist($artist->getName());
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], $e->getCode());
        }

        return $this->json([
            'artist' => $name,
            'albums' => [],
        ]);
    }
}