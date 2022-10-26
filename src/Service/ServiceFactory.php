<?php

namespace Moco\Service;

use Moco\MocoClient;

class ServiceFactory
{
    private static array $classMap = [
        'units' => UnitsService::class,
        'users' => UsersService::class,
        'companies' => CompaniesService::class
    ];

    protected array $services = [];
    private MocoClient $client;

    public function __construct(MocoClient $client)
    {
        $this->client = $client;
    }

    protected function getServiceClass(string $name): string|null
    {
        return \array_key_exists($name, self::$classMap) ? self::$classMap[$name] : null;
    }

    public function __get(string $name)
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
