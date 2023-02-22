<?php

declare(strict_types=1);

namespace App\Requests;

class EndRoundRequestData
{
    private string $roundId;
    private int $providerId;
    private int $reward;
    private string $sign;

    public function __construct(string $roundId, int $reward, int $providerId, string $sign)
    {

        $this->roundId = $roundId;
        $this->reward = $reward;
        $this->providerId = $providerId;
        $this->sign = $sign;
    }

    public function getData(): array
    {
        return [
            'round_id' => $this->roundId,
            'reward' => $this->reward,
            'provider_id' => $this->providerId,
            'sign' => $this->sign,
        ];
    }
}
