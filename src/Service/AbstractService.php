<?php

namespace Moco\Service;

use Moco\Entity\MocoEntityInterface;
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

    public function validateParams(MocoEntityInterface $mocoEntity, array $params): void
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

    public function prepareParams(array $params): array
    {
        foreach ($params as $key => $param) {
            if (is_bool($param)) {
                $params[$key] = $param ? 'true' : 'false';
            }
        }
        return $params;
    }
}
