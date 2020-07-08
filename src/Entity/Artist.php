<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Artist
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}