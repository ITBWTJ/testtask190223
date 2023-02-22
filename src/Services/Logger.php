<?php

declare(strict_types=1);

namespace App\Services;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

class Logger extends AbstractLogger implements LoggerInterface
{
    private string $logFilePath;
    public function __construct(Config $config)
    {
        $this->logFilePath = $config->get('logs.log_file_path', 'logs/error.log');

        if (!file_exists($this->logFilePath)) {
            touch($this->logFilePath);
        }
    }

    public function log($level, $message, array $context = []): void
    {
        file_put_contents(
            $this->logFilePath,
            json_encode(
                [
                'level' => $level,
                'message' => $message,
                'context' => $context,
                'time' => date(DATE_RFC850),
                ]
            ) . PHP_EOL,
            FILE_APPEND
        );
    }
}
