<?php

namespace App\Exceptions;

use Exception;

final class FilmsRepositoryException extends Exception
{
    public function getStatusCode(): int
    {
        return 500;
    }

}
