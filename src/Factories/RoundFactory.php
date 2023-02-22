<?php

declare(strict_types=1);

namespace App\Factories;

use App\Interfaces\Entities\RoundInterface;
use App\Interfaces\FileTypes\FileType;
use App\Interfaces\Transformers\RoundTransformerInterface;

class RoundFactory
{
    public function make(RoundTransformerInterface $transformer, string $type, string $content): RoundInterface
    {
        if (FileType::JSON === $type) {
            return $transformer->fromJson($content);
        } elseif (FileType::XML === $type) {
            return $transformer->fromXML($content);
        } else {
            throw new \Exception('Unsupported file type: ' . $type);
        }
    }
}
