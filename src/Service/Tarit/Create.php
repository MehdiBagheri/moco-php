<?php

namespace Moco\Service\Tarit;

use Moco\Entity\MocoEntityInterface;

trait Create
{
    public function create(array $params): MocoEntityInterface
    {
        $this->validateParams($this->getMocoObject(), $params);
        $params = $this->prepareParams($params);
        $result = $this->client->request('POST', $this->getEndPoint(), $params);

        return $this->createMocoEntity(json_decode($result), $this->getMocoObject());
    }
}
