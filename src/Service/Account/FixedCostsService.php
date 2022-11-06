<?php

namespace Moco\Service\Account;

use Moco\Entity\FixedCosts;
use Moco\Entity\MocoEntityInterface;
use Moco\Exception\InvalidRequestException;
use Moco\Service\AbstractService;

class FixedCostsService extends AbstractService
{
    protected function getEndpoint(): string
    {
        return $this->endpoint . 'account/fixed_costs';
    }

    protected function getEntity(): string
    {
        return FixedCosts::class;
    }

    protected function getMocoObject(): MocoEntityInterface
    {
        return new FixedCosts();
    }

    public function get(int|array|null $params = null): FixedCosts|array|null
    {
        if (!empty($params) && !is_array($params)) {
            throw new InvalidRequestException('Fixed costs does not support fetch single entity');
        }
        return parent::get($params);
    }

    public function create(array $params): MocoEntityInterface
    {
        throw new InvalidRequestException('Fixed costs does not support create function.');
    }

    public function update(int $id, array $params): MocoEntityInterface
    {
        throw new InvalidRequestException('Fixed costs does not support update function.');
    }

    public function delete(int $id): void
    {
        throw new InvalidRequestException('Fixed costs does not support delete function.');
    }
}
