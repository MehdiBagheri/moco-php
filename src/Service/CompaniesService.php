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
class CompaniesService extends AbstractService implements ServiceInterface
{
    public function getEndPoint(): string
    {
        return parent::getEndpoint() . 'companies';
    }

    public function getEntity(): string
    {
        return Company::class;
    }

    public function getMocoObject(): MocoEntityInterface
    {
        return new Company();
    }
}
