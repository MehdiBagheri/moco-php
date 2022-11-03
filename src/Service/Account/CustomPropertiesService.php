<?php

namespace Moco\Service\Account;

use Moco\Entity\CustomProperty;
use Moco\Entity\MocoEntityInterface;
use Moco\Exception\InvalidRequestException;
use Moco\Service\AbstractService;

/**
 * @method CustomProperty|array|null get(int|array|null $params = null)
 */
class CustomPropertiesService extends AbstractService
{
    protected function getEndpoint(): string
    {
        return $this->endpoint . 'account/custom_properties';
    }

    protected function getEntity(): string
    {
        return CustomProperty::class;
    }

    protected function getMocoObject(): CustomProperty
    {
        return new CustomProperty();
    }

    public function create(array $params): MocoEntityInterface
    {
        throw new InvalidRequestException('Custom properties does not support create function.');
    }

    public function update(int $id, array $params): MocoEntityInterface
    {
        throw new InvalidRequestException('Custom properties does not support update function.');
    }

    public function delete(int $id): void
    {
        throw new InvalidRequestException('Custom properties does not support delete function.');
    }
}
