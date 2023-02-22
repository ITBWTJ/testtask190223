<?php

declare(strict_types=1);

namespace App\Interfaces\Factories;

use App\Interfaces\Entities\RoundInterface;
use App\Interfaces\Requests\RequestDataInterface;

interface RequestDataFactoryInterface
{
    public function makeStartRoundData(RoundInterface $round, int $providerId, string $sign): RequestDataInterface;
}
