<?php

namespace Moco\Entity;

class AbstractMocoEntity
{
    public function __set(string $name, mixed $value): void
    {
        $this->$name = $value;
    }
}
