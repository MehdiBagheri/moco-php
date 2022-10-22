<?php

namespace Moco;

use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Moco\Exception\InvalidResponseException;
use Moco\Service\ServiceFactory;
use Moco\Service\ServiceInterface;
use Moco\Service\UnitsService;
use Moco\Service\UsersService;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @property UnitsService $units
 * @property UsersService $users
 */
class MocoClient
{
    private string $token;
    private string $endpoint;
    private ServiceFactory $serviceFactory;
    private ClientInterface $client;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $messageStream;

    public function __construct(array $params)
    {
        if (isset($params['endpoint']) && isset($params['token'])) {
            $this->setEndpoint($params['endpoint']);
            $this->token = $params['token'];
        } else {
            throw new \Exception('Please provide endpoint and token');
        }

        $this->client = HttpClientDiscovery::find();
        $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $this->messageStream = Psr17FactoryDiscovery::findStreamFactory();
        $this->serviceFactory = new ServiceFactory($this);
    }

    public function __get(string $name): ServiceInterface
    {
        return $this->serviceFactory->__get($name);
    }

    public function request(string $method, string $endpoint, array $params = []): string
    {
        $request = $this->requestFactory->createRequest($method, $endpoint)
                                        ->withHeader('Authorization', $this->getAuthHeader())
                                        ->withHeader('Accept', 'application/json')
                                        ->withHeader('Content-Type', 'application/json')
                                        ->withBody($this->messageStream->createStream(json_encode($params)));
        $response = $this->client->sendRequest($request);

        return $this->createResponse($response);
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    private function setEndpoint(string $endpoint): void
    {
        $lastChar = substr($endpoint, -1);
        if ($lastChar != '/') {
            $endpoint .= '/';
        }
        $this->endpoint = $endpoint;
    }

    private function createResponse(ResponseInterface $response): string
    {
        if (!in_array($response->getStatusCode(), [200, 204])) {
            throw new InvalidResponseException(
                $response->getBody()->getContents(),
                $response->getStatusCode()
            );
        }

        return $response->getBody()->getContents();
    }

    private function getAuthHeader(): string
    {
        return 'Token token=' . $this->token;
    }
}
