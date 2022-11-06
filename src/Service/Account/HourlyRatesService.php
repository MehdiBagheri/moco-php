<?php

namespace Moco\Service\Account;

use Moco\Entity\HourlyRate;
use Moco\Entity\MocoEntityInterface;
use Moco\Exception\InvalidRequestException;
use Moco\Service\AbstractService;

class HourlyRatesService extends AbstractService
{
    protected function getEndpoint(): string
    {
        return $this->endpoint . 'account/hourly_rates';
    }

    protected function getEntity(): string
    {
        return HourlyRate::class;
    }

    protected function getMocoObject(): MocoEntityInterface
    {
        return new HourlyRate();
    }

    public function get(int|array|null $params = null): HourlyRate|array|null
    {
        if (!empty($params) && !is_array($params)) {
            throw new InvalidRequestException('Hourly rates does not support fetch single entity');
        }
        return parent::get($params);
    }

    public function create(array $params): MocoEntityInterface
    {
        throw new InvalidRequestException('Hourly rates does not support create function.');
    }

    public function update(int $id, array $params): MocoEntityInterface
    {
        throw new InvalidRequestException('Hourly rates does not support update function.');
    }

    public function delete(int $id): void
    {
        throw new InvalidRequestException('Hourly rates does not support delete function.');
    }
}
