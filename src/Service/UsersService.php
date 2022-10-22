<?php

namespace Moco\Service;

use Moco\Entity\User;
use Moco\Util\Util;

class UsersService extends AbstractService implements ServiceInterface
{
    public function getEndPoint(): string
    {
        return $this->endpoint . 'users';
    }

    public function create(array $params): User
    {
        $this->validateParams(new User(), $params);
        $params = $this->prepareParams($params);
        $result = $this->client->request('POST', $this->getEndPoint(), $params);
        return Util::createMocoEntity(json_decode($result), User::class);
    }

    /**
     * @param int|array|null $params
     *
     * @return User|User[]|null
     */
    public function get(int|array|null $params = null): User|array|null
    {
        if (is_array($params)) {
            $params = $this->prepareParams($params);
            $urlQuery = '?' . http_build_query($params);
            $result = $this->client->request("GET", $this->getEndPoint() . $urlQuery);
        } else {
            $result = $this->client->request("GET", $this->getEndPoint() . '/' . $params);
        }

        $result = json_decode($result);
        if (is_array($result)) {
            $users = [];
            foreach ($result as $user) {
                $users[] = Util::createMocoEntity($user, User::class);
            }
            return $users;
        } else {
            return Util::createMocoEntity($result, User::class);
        }
    }

    public function update(int $userId, array $params): User
    {
        $params = $this->prepareParams($params);
        $result = $this->client->request("PUT", $this->getEndPoint() . '/' . $userId, $params);
        return Util::createMocoEntity(json_decode($result), User::class);
    }

    public function delete(int $userId): void
    {
        $this->client->request("DELETE", $this->getEndPoint() . '/' . $userId);
    }

    public function getPerformanceReport(int $userId, array $params = null): array
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
