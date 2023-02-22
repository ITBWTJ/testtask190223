<?php

declare(strict_types=1);

namespace App\Exceptions\OnlyPlayClient;

use Throwable;

class EmptyResponseRoundException extends RoundException
{
    public function __construct($message = 'Empty response from round api', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
