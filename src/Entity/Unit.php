<?php

namespace Moco\Entity;

/**
 * @property int $id
 * @property string $name
 */
class Unit extends AbstractMocoEntity
{
    public function getMandatoryFields(): array
    {
        return [];
    }
}
