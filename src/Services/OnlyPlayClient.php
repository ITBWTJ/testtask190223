<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Factories\OnlyPlayResponseException;
use App\Exceptions\HTTPClient\HTTPException;
use App\Exceptions\OnlyPlayClient\EmptyResponseRoundException;
use App\Exceptions\OnlyPlayClient\RoundException;
use App\Factories\ResponseFactory;
use App\Requests\EndRoundRequestData;
use App\Requests\StartRoundRequestData;
use App\Responses\OnlyPlayResponse;

class OnlyPlayClient
{
    private HTTPClient $client;
    private Config $config;

    private string $baseUrl;
    private string $startRoundUrl;
    private string $endRoundUrl;
    private ResponseFactory $responseFactory;

    public function __construct(HTTPClient $client, Config $config, ResponseFactory $responseFactory)
    {
        $this->client = $client;
        $this->config = $config;

        $this->baseUrl = $this->config->get('onlyplay.base_url');
        $this->startRoundUrl = $this->baseUrl . $this->config->get('onlyplay.start_round_url');
        $this->endRoundUrl = $this->baseUrl . $this->config->get('onlyplay.end_round_url');
        $this->responseFactory = $responseFactory;
    }

    public function startRound(StartRoundRequestData $requestData): OnlyPlayResponse
    {
        return $this->request($this->startRoundUrl, $requestData->getData());
    }

    public function endRound(EndRoundRequestData $requestData): OnlyPlayResponse
    {
        return $this->request($this->endRoundUrl, $requestData->getData());
    }

    protected function request(string $url, array $data): OnlyPlayResponse
    {
        try {
            $responseData = $this->client->post($url, $data);

            if (empty($responseData)) {
                throw new EmptyResponseRoundException();
            }

            return $this->responseFactory->make($responseData);
        } catch (HTTPException $e) {
            throw new RoundException('Start round error', 400, $e);
        } catch (OnlyPlayResponseException $e) {
            throw new RoundException('Start round response validation error', 400, $e);
        }
    }
}
