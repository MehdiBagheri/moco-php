<?php

namespace Moco\Service;

class UnitsService extends AbstractService implements ServiceInterface
{
    public function getEndPoint(): string
    {
        return parent::getEndpoint() . 'units';
    }
}
