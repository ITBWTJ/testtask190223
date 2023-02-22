<?php

declare(strict_types=1);

namespace App\Interfaces\Transformers;

use App\Interfaces\Entities\RoundInterface;

interface RoundTransformerInterface
{
    public function fromJson(string $json): RoundInterface;

    public function fromXML(string $xml): RoundInterface;
}
