<?php

declare(strict_types=1);

namespace App\Entities;

use App\Interfaces\Entities\RoundInterface;

class StartRound implements RoundInterface
{
    private string $roundId;
    private string $playerId;
    public function __construct(string $roundId, string $playerId)
    {
        $this->roundId = $roundId;
        $this->playerId = $playerId;
    }

    public function getPlayerId(): string
    {
        return $this->playerId;
    }

    public function getRoundId(): string
    {
        return $this->roundId;
    }

    public function getData(): array
    {
        return [
            'round_id' => $this->roundId,
            'player_id' => $this->playerId,
        ];
    }
}
