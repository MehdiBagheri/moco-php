<?php

namespace Moco\Entity;

/**
 * @property array $defaults_rates
 * @property Task[] $tasks
 * @property array $users
 */
class HourlyRate extends AbstractMocoEntity implements MocoEntityInterface
{
    public function getMandatoryFields(): array
    {
        return [];
    }
}
