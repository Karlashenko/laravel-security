<?php

declare(strict_types=1);

use Tests\TestCase;
use Phrantiques\Security\Core\Algorithms\DenyOverrides;
use Phrantiques\Security\Core\Algorithms\AlgorithmFactory;

class AlgorithmFactoryTest extends TestCase
{
    public function testAlgorithmFactoryCreatesAlgorithms(): void
    {
        $algorithm = AlgorithmFactory::make(DenyOverrides::class);

        $this->assertInstanceOf(DenyOverrides::class, $algorithm);
    }
}
