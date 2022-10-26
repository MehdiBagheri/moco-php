<?php

namespace Moco\Service;

use Moco\Entity\MocoEntityInterface;
use Moco\Entity\User;

class UsersService extends AbstractService
{
    public function getEndPoint(): string
    {
        return $this->endpoint . 'users';
    }

    public function getEntity(): string
    {
        return User::class;
    }

    public function getMocoObject(): MocoEntityInterface
    {
        return new User();
    }

    public function getPerformanceReport(int $userId, array $params = null): object
    {
        $urlQuery = '';
        if (is_array($params)) {
            $urlQuery = '?' . http_build_query($params);
        }
        $endpoint = $this->getEndPoint() . '/' . $userId . '/performance_report' . $urlQuery;
        $result = $this->client->request("GET", $endpoint);

        return json_decode($result);
    }
}
