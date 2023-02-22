<?php

declare(strict_types=1);

namespace App\Services;

class FileReader
{
    public function getFilesFromDirectory(string $directory): array
    {
        return scandir($directory);
    }

    public function getFilesFromDirectoryByPattern(string $directoryPattern): array
    {
        return glob($directoryPattern);
    }

    public function getFileType(string $filename): string
    {
        return pathinfo($filename, PATHINFO_EXTENSION);
    }

    public function getFileContent(string $filename): string
    {
        return file_get_contents($filename);
    }

    public function getFileNameFromPath(string $path): string
    {
        return basename($path);
    }
}
