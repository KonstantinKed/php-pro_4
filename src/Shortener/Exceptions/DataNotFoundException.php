<?php

namespace App\Shortener\Exceptions;

use Exception;

class DataNotFoundException extends Exception
{
    protected $message = 'Code not found';
}