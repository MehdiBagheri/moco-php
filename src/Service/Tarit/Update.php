<?php

namespace Moco\Service\Tarit;

use Moco\Entity\MocoEntityInterface;

trait Update
{
    public function update(int $id, array $params): MocoEntityInterface
    {
        $params = $this->prepareParams($params);
        $result = $this->client->request("PUT", $this->getEndPoint() . '/' . $id, $params);

        return $this->createMocoEntity(json_decode($result), $this->getEntity());
    }
}
