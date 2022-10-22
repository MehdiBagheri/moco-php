<?php

namespace Moco\Util;

use Moco\Entity\MocoEntityInterface;

class Util
{
    public static function createMocoEntity(\stdClass $data, string $entity): MocoEntityInterface
    {
        $entity = new $entity();
        foreach ($data as $key => $item) {
            $entity->$key = $item;
        }
        return $entity;
    }
}
