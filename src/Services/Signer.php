<?php

declare(strict_types=1);

namespace App\Services;

class Signer
{
    public function generate(string $json, string $key): string
    {
        return hash_hmac('sha256', $json, $key);
    }
}
