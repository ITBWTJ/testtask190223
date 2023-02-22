<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\HTTPClient\HTTPException;

class HTTPClient
{
    private int $timeout;

    public function __construct(int $timeout = 3)
    {
        $this->timeout = $timeout;
    }

    public function post(string $url, array $data, array $headers = [])
    {
        $ch = curl_init($url);

        var_dump($url);
        var_dump(json_encode($data));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        $response = curl_exec($ch);
        var_dump($response);

        if ($response === false) {
            throw new HTTPException('HTTP request failed: ' . curl_error($ch));
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($statusCode < 200 || $statusCode > 299) {
            throw new HTTPException('HTTP request failed with status code: ' . $statusCode);
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}
