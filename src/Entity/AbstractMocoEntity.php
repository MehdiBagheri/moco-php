<?php

namespace Moco\Entity;

class AbstractMocoEntity
{
    public function __set(string $name, $value): void
    {
        $this->$name = $value;
    }
}
