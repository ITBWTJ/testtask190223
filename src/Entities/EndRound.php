<?php

declare(strict_types=1);

namespace App\Entities;

use App\Interfaces\Entities\RoundInterface;

class EndRound implements RoundInterface
{
    private string $roundId;
    private int $reward;
    public function __construct(string $roundId, int $reward)
    {

        $this->roundId = $roundId;
        $this->reward = $reward;
    }

    public function getReward(): int
    {
        return $this->reward;
    }

    public function getRoundId(): string
    {
        return $this->roundId;
    }

    public function getData(): array
    {
        return [
            'round_id' => $this->roundId,
            'reward' => $this->reward,
        ];
    }
}
