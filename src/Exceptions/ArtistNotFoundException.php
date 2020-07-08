<?php

namespace App\Exceptions;

class ArtistNotFoundException extends \Exception
{
    protected $message = 'artist not found';
}
