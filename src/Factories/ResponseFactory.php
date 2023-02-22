<?php

declare(strict_types=1);

namespace App\Factories;

use App\Exceptions\Factories\OnlyPlayResponseException;
use App\Responses\OnlyPlayResponse;

class ResponseFactory
{
    public function make(array $data): OnlyPlayResponse
    {
        $this->checkData($data);

        return new OnlyPlayResponse($data['success'], $data['message'], $data['code'] ?? null, $data['action_id'] ?? null);
    }

    protected function checkData(array $data): void
    {
        foreach (['success', 'message'] as $key) {
            if (!array_key_exists($key, $data)) {
                throw new OnlyPlayResponseException("$key is not in the array");
            }
        }
    }
}
