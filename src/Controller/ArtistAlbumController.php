<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

class ArtistAlbumController extends AbstractController
{
    /**
     * @Route("/artists/{artist}", methods="GET", name="artist_albums")
     */
    public function albums($artist)
    {
        $validator = Validation::createValidator();

        $violations = $validator->validate($artist, [
            new Length(['min' => 3]),
            new NotBlank(),
        ]);

        if (0 !== count($violations)) {
            return $this->json([
                'errors' => $this->getValidationMessages($violations),
            ]);
        }

        return $this->json([
            'artist' => $artist,
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