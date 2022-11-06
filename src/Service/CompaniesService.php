<?php

namespace Moco\Service;

use Moco\Entity\Company;
use Moco\Entity\MocoEntityInterface;
use Moco\Service\Tarit\Create;
use Moco\Service\Tarit\Delete;
use Moco\Service\Tarit\Get;
use Moco\Service\Tarit\Update;

/**
 * @method Company create(array $params)
 * @method Company|array|null get(int|array|null $params = null)
 * @method Company update(int $id, array $params)
 * @method void delete(int $id)
 */
class CompaniesService extends AbstractService
{
    use Get;
    use Create;
    use Update;
    use Delete;

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
