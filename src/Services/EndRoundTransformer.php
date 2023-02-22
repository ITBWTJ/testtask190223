<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\EndRound;
use App\Interfaces\Transformers\RoundTransformerInterface;

class EndRoundTransformer implements RoundTransformerInterface
{
    public function fromJson(string $json): EndRound
    {
        $data = json_decode($json, true, JSON_THROW_ON_ERROR);

        return new EndRound($data['roundId'], $data['reward']);
    }

    public function fromXML(string $xml): EndRound
    {
        $element = simplexml_load_string($xml);
        $roundId = (string) $element->{'round-id'};
        $reward = (int) $element->{'reward'};

        return new EndRound($roundId, $reward);
    }
}
