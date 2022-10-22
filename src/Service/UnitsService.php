<?php

namespace Moco\Service;

use Moco\Entity\User;

class UnitsService extends AbstractService implements ServiceInterface
{
    public function getEndPoint(): string
    {
        return $this->endpoint . 'units';
    }


    public function get(array|int|null $params = null): User|array|null
    {
        return null;
    }
}
