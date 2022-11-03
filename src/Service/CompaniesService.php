<?php

namespace Moco\Service;

use Moco\Entity\Company;
use Moco\Entity\MocoEntityInterface;

/**
 * @method Company create(array $params)
 * @method Company|array|null get(int|array|null $params = null)
 * @method Company update(int $id, array $params)
 * @method void delete(int $id)
 */
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
