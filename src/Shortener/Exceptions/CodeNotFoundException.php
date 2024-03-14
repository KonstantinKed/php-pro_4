<?php

namespace App\Shortener\Exceptions;

use Exception;

class CodeNotFoundException extends Exception
{
    protected $message = 'Code not found';
}