<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\EndRound;
use App\Entities\StartRound;
use App\Exceptions\OnlyPlayClient\RoundException;
use App\Factories\RequestDataFactory;
use App\Interfaces\Entities\RoundInterface;
use App\Interfaces\RequestTypes\RequestType;
use Psr\Log\LoggerInterface;

class RoundService
{
    private RequestDataFactory $requestStartDataFactory;
    private Signer $sign;
    private Config $config;
    private LoggerInterface $logger;
    private OnlyPlayClient $onlyPlayClient;
    private int $providerId;
    private string $key;


    public function __construct(
        Config $config,
        RequestDataFactory $requestStartDataFactory,
        Signer $sign,
        OnlyPlayClient $onlyPlayClient,
        LoggerInterface $logger
    ) {
        $this->requestStartDataFactory = $requestStartDataFactory;
        $this->sign = $sign;
        $this->config = $config;
        $this->onlyPlayClient = $onlyPlayClient;

        $this->providerId = $this->config->get('onlyplay.provider_id');
        $this->key = $this->config->get('onlyplay.key');
        $this->logger = $logger;
    }

    public function startRound(StartRound $round): void
    {
        $jsonData = $this->getJsonData($round);

        $sign = $this->sign->generate($jsonData, $this->key);

        $requestData = $this->requestStartDataFactory->makeStartRoundData($round, $this->providerId, $sign);

        try {
            $response = $this->onlyPlayClient->startRound($requestData);
            $this->logger->info(
                'Start Round',
                [
                'request_type' => RequestType::START_ROUND,
                'success' => $response->isSuccess(),
                'error_message' => $response->getMessage(),
                'action_id' => $response->getActionId(),
                'data' => $round->getData(),
                ]
            );
        } catch (RoundException $e) {
            $this->writeErrorLog('Start Round', $e);
        }
    }

    public function endRound(EndRound $round): void
    {
        $jsonData = $this->getJsonData($round);

        $sign = $this->sign->generate($jsonData, $this->key);
        $requestData = $this->requestStartDataFactory->makeEndRoundData($round, $this->providerId, $sign);

        try {
            $response = $this->onlyPlayClient->endRound($requestData);

            $this->logger->info(
                'End Round',
                [
                'request_type' => RequestType::START_ROUND,
                'success' => $response->isSuccess(),
                'error_message' => $response->getMessage(),
                'action_id' => $response->getActionId(),
                'round' => $round->getData(),
                ]
            );
        } catch (RoundException $e) {
            $this->writeErrorLog('End Round', $e);
        }
    }

    private function getJsonData(RoundInterface $round): string
    {
        $data = $round->getData();
        $data['provider_id'] = $this->providerId;

        return json_encode($data);
    }

    private function writeErrorLog(string $message, \Exception $e): void
    {
        $data['message'] = $e->getMessage();

        if ($e->getPrevious() !== null) {
            $data['previous_exception'] = [
                'message' => $e->getPrevious()->getMessage(),
                'exception' => get_class($e->getPrevious()),
            ];
        }

        $this->logger->error($message, $data);
    }
}
