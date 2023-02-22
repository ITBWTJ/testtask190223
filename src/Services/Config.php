<?php

declare(strict_types=1);

namespace App\Services;

class Config
{
    protected $data;

    public function __construct(array $config)
    {
        $this->data = $config;
    }

    public function get($key, $default = null)
    {
        $parts = explode('.', $key);
        $current = $this->data;
        foreach ($parts as $part) {
            if (isset($current[$part])) {
                $current = $current[$part];
            } else {
                return $default;
            }
        }
        return $current;
    }
}
