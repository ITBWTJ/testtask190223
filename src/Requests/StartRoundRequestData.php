<?php

declare(strict_types=1);

namespace App\Requests;

use App\Interfaces\Requests\RequestDataInterface;

class StartRoundRequestData implements RequestDataInterface
{
    private string $roundId;
    private int $providerId;
    private string $playerId;
    private string $sign;

    public function __construct(string $roundId, string $playerId, int $providerId, string $sign)
    {

        $this->roundId = $roundId;
        $this->playerId = $playerId;
        $this->providerId = $providerId;
        $this->sign = $sign;
    }

    public function getData(): array
    {
        return [
            'round_id' => $this->roundId,
            'player_id' => $this->playerId,
            'provider_id' => $this->providerId,
            'sign' => $this->sign,
        ];
    }
}
