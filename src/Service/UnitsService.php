<?php

namespace Moco\Service;

use Moco\Entity\MocoEntityInterface;
use Moco\Entity\Unit;

class UnitsService extends AbstractService
{
    public function getEndPoint(): string
    {
        return $this->endpoint . 'units';
    }

    protected function getMocoObject(): MocoEntityInterface
    {
        return new Unit();
    }
}
