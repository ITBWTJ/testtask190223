<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';
const HOME_DIR = __DIR__;
const CONFIG_FILE = 'config.php';
const DIRECTORY_WITH_REQUESTS = 'requests';
const CONFIG_FILE_PATH = HOME_DIR . '/' . CONFIG_FILE;
if (!file_exists(CONFIG_FILE_PATH)) {
    throw new Exception('Config file does not exists');
}

$config = new \App\Services\Config(include CONFIG_FILE_PATH);
$fileReader = new \App\Services\FileReader();
$startRoundFiles = $fileReader->getFilesFromDirectoryByPattern(DIRECTORY_WITH_REQUESTS . '/start_round_*.*');
$files = $fileReader->getFilesFromDirectoryByPattern(DIRECTORY_WITH_REQUESTS . '/start_round_*.*');
$logger = new \App\Services\Logger($config);
$startRoundTransformer = new \App\Services\StartRoundTransformer();
$endRoundTransformer = new \App\Services\EndRoundTransformer();
$roundFactory = new \App\Factories\RoundFactory();
$requestStartDataFactory = new \App\Factories\RequestDataFactory();
$signService = new \App\Services\Signer();
$httpClient = new \App\Services\HTTPClient();
$responseFactory = new \App\Factories\ResponseFactory();
$onlyPlayClient = new \App\Services\OnlyPlayClient($httpClient, $config, $responseFactory);
$roundService = new \App\Services\RoundService($config, $requestStartDataFactory, $signService, $onlyPlayClient, $logger);

foreach ($startRoundFiles as $filepath) {
    $fileType = $fileReader->getFileType($filepath);
    $filename = $fileReader->getFileNameFromPath($filepath);
    $content = $fileReader->getFileContent($filepath);
    $startRound = $roundFactory->make($startRoundTransformer, $fileType, $content);
    $roundNumber = \App\Services\GetFileNumber::getFileNumber($filename);
    $content = $fileReader->getFileContent(DIRECTORY_WITH_REQUESTS . '/end_round_' . $roundNumber . '.' . $fileType);
    $endRound = $roundFactory->make($endRoundTransformer, $fileType, $content);
    $roundService->startRound($startRound);
    $roundService->endRound($endRound);
}
