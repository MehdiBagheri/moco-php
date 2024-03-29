<?php

namespace Moco\Service;

use Moco\Entity\AbstractMocoEntity;
use Moco\Exception\InvalidRequestException;
use Moco\MocoClient;

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
    abstract protected function getMocoObject(): AbstractMocoEntity;

    protected function validateParams(array $mandatoryFields, array $params): void
    {
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

    protected function prepareParams(array $params): array
    {
        foreach ($params as $key => $param) {
            if (is_bool($param)) {
                $params[$key] = $param ? 'true' : 'false';
            }
        }

        return $params;
    }

    protected function createMocoEntity(\stdClass $data, AbstractMocoEntity $entity): AbstractMocoEntity
    {
        $data = (array) $data;
        foreach ($data as $key => $item) {
            $entity->$key = $item;
        }
        return $entity;
    }
}
