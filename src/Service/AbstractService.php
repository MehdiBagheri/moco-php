<?php

namespace Moco\Service;

use Moco\Entity\MocoEntityInterface;
use Moco\Exception\InvalidRequestException;
use Moco\MocoClient;
use Moco\Util\Util;

abstract class AbstractService
{
    protected MocoClient $client;
    protected string $endpoint;

    public function __construct(MocoClient $client)
    {
        $this->client = $client;
        $this->endpoint = $client->getEndpoint();
    }

    abstract protected function getEndpoint(): string;
    abstract protected function getEntity(): string;
    abstract protected function getMocoObject(): MocoEntityInterface;

    public function create(array $params): MocoEntityInterface
    {
        $this->validateParams($this->getMocoObject(), $params);
        $params = $this->prepareParams($params);
        $result = $this->client->request('POST', $this->getEndPoint(), $params);

        return Util::createMocoEntity(json_decode($result), $this->getEntity());
    }

    public function get(int|array|null $params = null): MocoEntityInterface|array|null
    {
        if (is_array($params)) {
            $params = $this->prepareParams($params);
            $urlQuery = '?' . http_build_query($params);
            $result = $this->client->request("GET", $this->getEndPoint() . $urlQuery);
        } else {
            $result = $this->client->request("GET", $this->getEndPoint() . '/' . $params);
        }

        $result = json_decode($result);
        if (is_array($result)) {
            $entities = [];
            foreach ($result as $entity) {
                $entities[] = Util::createMocoEntity($entity, $this->getEntity());
            }

            return $entities;
        } else {
            return Util::createMocoEntity($result, $this->getEntity());
        }
    }

    public function update(int $id, array $params): MocoEntityInterface
    {
        $params = $this->prepareParams($params);
        $result = $this->client->request("PUT", $this->getEndPoint() . '/' . $id, $params);

        return Util::createMocoEntity(json_decode($result), $this->getEntity());
    }

    public function delete(int $id): void
    {
        $this->client->request("DELETE", $this->getEndPoint() . '/' . $id);
    }

    private function validateParams(MocoEntityInterface $mocoEntity, array $params): void
    {
        $mandatoryFields = $mocoEntity->getMandatoryFields();
        foreach ($mandatoryFields as $mandatoryField) {
            if (!isset($params[$mandatoryField])) {
                throw new InvalidRequestException(
                    'The parameter(' . $mandatoryField . ') is missing or it does not have same 
                    format/structure as API. 
                    The following params are mandatory => ' . implode(', ', $mandatoryFields)
                );
            }
        }
    }

    private function prepareParams(array $params): array
    {
        foreach ($params as $key => $param) {
            if (is_bool($param)) {
                $params[$key] = $param ? 'true' : 'false';
            }
        }

        return $params;
    }
}
