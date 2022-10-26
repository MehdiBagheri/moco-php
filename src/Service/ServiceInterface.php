<?php

namespace Moco\Service;

use Moco\Entity\MocoEntityInterface;

interface ServiceInterface
{
    public function getEndPoint(): string;
    public function getEntity(): string;
    public function getMocoObject(): MocoEntityInterface;
}
