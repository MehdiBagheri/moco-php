<?php

namespace Moco\Service;

use Moco\Entity\User;

interface ServiceInterface
{
    public function getEndPoint(): string;
    public function get(int|array|null $params = null): User|array|null;
}
