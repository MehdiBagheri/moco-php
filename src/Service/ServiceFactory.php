<?php

namespace Moco\Service;

use Moco\MocoClient;
use Moco\Service\Deal\DealCategoryService;

class ServiceFactory
{
    private array $classMap = [
        'units' => UnitsService::class,
        'users' => UsersService::class,
        'companies' => CompaniesService::class,
        'account' => AccountServiceFactory::class,
        'projects' => ProjectsService::class,
        'projectTasks' => ProjectTasksService::class,
        'activities' => ActivitiesService::class,
        'comments' => CommentsService::class,
        'contacts' => ContactsService::class,
        'dealCategory' => DealCategoryService::class
    ];

    protected array $services = [];
    private MocoClient $client;

    public function __construct(MocoClient $client)
    {
        $this->client = $client;
    }

    protected function getServiceClass(string $name): string|null
    {
        return \array_key_exists($name, $this->classMap) ? $this->classMap[$name] : null;
    }

    public function __get(string $name): AbstractService|AccountServiceFactory|null
    {
        $serviceClass = $this->getServiceClass($name);
        if (!is_null($serviceClass)) {
            if (!array_key_exists($name, $this->services)) {
                $this->services[$name] = new $serviceClass($this->client);
            }

            return $this->services[$name];
        }

        return null;
    }
}
