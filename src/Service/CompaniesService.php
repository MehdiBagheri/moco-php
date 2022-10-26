<?php

namespace Moco\Service;

use Moco\Entity\Company;
use Moco\Entity\MocoEntityInterface;

class CompaniesService extends AbstractService
{
    protected function getEndPoint(): string
    {
        return $this->endpoint . 'companies';
    }

    protected function getEntity(): string
    {
        return Company::class;
    }

    protected function getMocoObject(): MocoEntityInterface
    {
        return new Company();
    }
}
