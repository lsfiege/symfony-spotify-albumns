<?php

namespace App\Controller;

use App\Entity\Artist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ArtistAlbumController extends AbstractController
{
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

        return $this->json([
            'artist' => $artist->getName(),
            'albums' => [],
        ]);
    }

    protected function getValidationMessages(ConstraintViolationListInterface $violations): array
    {
        $errors = [];

        foreach ($violations as $violation) {
            $errors[] = $violation->getMessage();
        }

        return $errors;
    }
}