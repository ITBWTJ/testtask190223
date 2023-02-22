<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\StartRound;
use App\Interfaces\Transformers\RoundTransformerInterface;

class StartRoundTransformer implements RoundTransformerInterface
{
    public function fromJson(string $json): StartRound
    {
        $data = json_decode($json, true, JSON_THROW_ON_ERROR);

        return new StartRound($data['roundId'], $data['playerId']);
    }

    public function fromXML(string $xml): StartRound
    {
        $element = simplexml_load_string($xml);
        $roundId = (string) $element->{'round-id'};
        $playerId = (string) $element->{'player-id'};

        return new StartRound($roundId, $playerId);
    }
}
