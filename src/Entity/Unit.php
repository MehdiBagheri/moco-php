<?php

namespace Moco\Entity;

/**
 * @property int $id
 * @property string $name
 */
class Unit extends AbstractMocoEntity implements MocoEntityInterface
{
    public function getMandatoryFields(): array
    {
        return [];
    }
}
