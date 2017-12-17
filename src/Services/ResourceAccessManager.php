<?php

declare(strict_types=1);

namespace Phrantiques\Security\Services;

use App\ResourceDescriptions\Properties\MultiKeyable;

class ResourceAccessManager
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function readableProperties($subject, $resource, array $properties): array
    {
        return $this->actionableProperties($subject, $resource, Security::ACTION_READ, $properties);
    }

    public function isAllowedProperties($subject, $resource, string $action, array $properties): bool
    {
        return count($properties) === count($this->actionableProperties($subject, $resource, $action, $properties));
    }

    private function actionableProperties($subject, $resource, string $action, array $properties): array
    {
        $readable = [];

        foreach ($properties as $properyName => $property) {
            if (is_array($property)) {
                $readable[$properyName] = $this->actionableProperties($subject, $resource, $action, $property);

                if (empty($readable[$properyName])) {
                    unset($readable[$properyName]);
                }

                continue;
            }

            $modelProperties = $property instanceof MultiKeyable ? $property->keys() : [$property->key()];

            if (!$this->security->isAuthorized($subject, $resource, $action, $modelProperties)) {
                continue;
            }

            $readable[$properyName] = $property;
        }

        return $readable;
    }
}
