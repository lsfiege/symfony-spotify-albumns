<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @Route("/albums", methods={"GET"}, name="artist_albums")
     */
    public function albums(Request $request, ValidatorInterface $validator)
    {
        $constraints = new Assert\Collection([
            'q' => new Assert\Length(['min' => 3])
        ]);

        $errors = $validator->validate($request->query->all(), $constraints);

        if (count($errors) > 0) {
            $errorsString = (string)$errors;

            return $this->json([
                'error' => $errorsString,
            ]);
        }

        $artist = $request->get('q');

        try {
            $artist = $this->service->searchArtist($artist);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], $e->getCode());
        }

        $albums = $this->service->searchArtistAlbums($artist->id);

        return $this->json([
            'artist' => $artist,
            'albums' => $this->formatAlbumsResponse($albums),
        ]);
    }

    private function formatAlbumsResponse(array $albums): array
    {
        if (empty($albums)) {
            return $albums;
        }

        $data = [];

        foreach ($albums as $album) {
            $data[] = [
                'name' => $album->name,
                'released' => $album->release_date,
                'tracks' => $album->total_tracks,
                'cover' => $album->images[0],
            ];
        }

        return $data;
    }
}