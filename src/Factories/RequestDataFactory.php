<?php

declare(strict_types=1);

namespace App\Factories;

use App\Entities\EndRound;
use App\Entities\StartRound;
use App\Requests\EndRoundRequestData;
use App\Requests\StartRoundRequestData;

class RequestDataFactory
{
    public function makeStartRoundData(StartRound $round, int $providerId, string $sign): StartRoundRequestData
    {
        return new StartRoundRequestData(
            $round->getRoundId(),
            $round->getPlayerId(),
            $providerId,
            $sign,
        );
    }

    public function makeEndRoundData(EndRound $round, int $providerId, string $sign): EndRoundRequestData
    {
        return new EndRoundRequestData(
            $round->getRoundId(),
            $round->getReward(),
            $providerId,
            $sign,
        );
    }
}
