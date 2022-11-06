<?php

namespace Moco\Service\Account;

use Moco\Entity\HourlyRate;
use Moco\Entity\MocoEntityInterface;
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

    public function get(array $params = null): MocoEntityInterface|array|null
    {
        $urlQuery = '';
        if (!is_null($params)) {
            $params = $this->prepareParams($params);
            $urlQuery = '?' . http_build_query($params);
        }

        $result = $this->client->request("GET", $this->getEndPoint() . $urlQuery);

        $result = json_decode($result);
        if (is_array($result)) {
            $entities = [];
            foreach ($result as $entity) {
                $entities[] = $this->createMocoEntity($entity, $this->getEntity());
            }

            return $entities;
        } else {
            return $this->createMocoEntity($result, $this->getEntity());
        }
    }
}
