<?php

namespace Moco;

use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Moco\Exception\InvalidRequestException;
use Moco\Exception\InvalidResponseException;
use Moco\Exception\NotFoundException;
use Moco\Service\AbstractService;
use Moco\Service\AccountServiceFactory;
use Moco\Service\ActivitiesService;
use Moco\Service\CommentsService;
use Moco\Service\CompaniesService;
use Moco\Service\ContactsService;
use Moco\Service\Deal\DealCategoryService;
use Moco\Service\Deal\DealService;
use Moco\Service\ProjectsService;
use Moco\Service\ProjectTasksService;
use Moco\Service\ServiceFactory;
use Moco\Service\UnitsService;
use Moco\Service\UsersService;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

//TODO
//Invoice Payments
//Invoice Reminders
//Invoices
//Offers
//Planning Entry (New Planning)
//Project Contracts
//Project Expenses
//Project Payment Schedules
//Project Recurring Expenses
//Purchase Categories
//Purchase Drafts
//Purchase Payments
//Purchases
//Receipts
//Schedules (Absences)
//Tags / Labels
//Units / Teams
//User Employments
//User Holidays
//User Presences
//User Work Time Adjustments
//Vat Codes
//WebHooks
//Reports

/**
 * @property UnitsService $units
 * @property UsersService $users
 * @property CompaniesService $companies
 * @property AccountServiceFactory $account
 * @property ProjectsService $projects
 * @property ProjectTasksService $projectTasks
 * @property ActivitiesService $activities
 * @property CommentsService $comments
 * @property ContactsService $contacts
 * @property DealCategoryService $dealCategory
 * @property DealService $deal
 */
class MocoClient
{
    protected string $token;
    protected string $endpoint;
    protected ServiceFactory $serviceFactory;
    protected RequestFactoryInterface $requestFactory;
    protected StreamFactoryInterface $messageStream;
    protected ClientInterface $client;

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

    public function __get(string $name): AbstractService|AccountServiceFactory|null
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

    protected function setEndpoint(string $endpoint): void
    {
        $lastChar = substr($endpoint, -1);
        if ($lastChar != '/') {
            $endpoint .= '/';
        }
        $this->endpoint = $endpoint;
    }

    protected function createResponse(ResponseInterface $response): string
    {
        if (in_array($response->getStatusCode(), range(200, 299))) {
            return $response->getBody()->getContents();
        } else {
            if (in_array($response->getStatusCode(), range(400, 499))) {
                if ($response->getStatusCode() === 404) {
                    throw new NotFoundException('Requested entity not found.');
                } else {
                    throw new InvalidRequestException(
                        $response->getBody()->getContents(),
                        $response->getStatusCode()
                    );
                }
            } else {
                throw new InvalidResponseException(
                    $response->getBody()->getContents(),
                    $response->getStatusCode()
                );
            }
        }
    }

    protected function getAuthHeader(): string
    {
        return 'Token token=' . $this->token;
    }
}
