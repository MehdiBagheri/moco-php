<?php

namespace Moco\Service;

use Moco\Entity\AbstractMocoEntity;
use Moco\Entity\Unit;

class UnitsService extends AbstractService
{
    public function getEndPoint(): string
    {
        return $this->endpoint . 'units';
    }

    protected function getMocoObject(): AbstractMocoEntity
    {
        return new Unit();
    }
}
