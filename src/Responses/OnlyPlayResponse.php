<?php

declare(strict_types=1);

namespace App\Responses;

class OnlyPlayResponse
{
    private bool $success;
    private ?string $actionId;
    private string $message;
    private $code;

    public function __construct(bool $success, string $message, $code, ?string $actionId)
    {
        $this->success = $success;
        $this->actionId = $actionId;
        $this->message = $message;
        $this->code = $code;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getActionId(): ?string
    {
        return $this->actionId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
