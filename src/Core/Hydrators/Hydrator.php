<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core\Hydrators;

interface Hydrator
{
    /**
     * Hydrate $object with the provided $data.
     *
     * @param array $data
     * @param mixed $object
     *
     * @return void
     */
    public function hydrate(array $data, $object): void;
}
