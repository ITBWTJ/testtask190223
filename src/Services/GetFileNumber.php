<?php

declare(strict_types=1);

namespace App\Services;

class GetFileNumber
{
    public static function getFileNumber(string $filename): string
    {
        preg_match('/\w+_(\d+)\.\w+/', $filename, $matches);

        $number = $matches[1];
        //
        //        if ($number < 10) {
        //            $number = '0' . $number;
        //        }

        return $number;
    }
}
