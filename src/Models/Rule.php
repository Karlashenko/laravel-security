<?php

declare(strict_types=1);

namespace Phrantiques\Security\Models;

use Illuminate\Database\Eloquent\Model;
use Phrantiques\Security\Support\Config;
use Phrantiques\Security\Services\Security;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rule extends Model
{
    public function policies(): BelongsToMany
    {
        return $this->belongsToMany(Policy::class, 'security_policies_rules', 'policy_id', 'rule_id');
    }

    public function getConditionAsString(): string
    {
        $getPropertyText = function (array $data) {
            $type     = array_get($data, 'type', '');
            $entity   = array_get($data, 'entity', '');
            $property = array_get($data, 'key', '');

            $pieces = [];

            if ($type !== Security::PROPERTY_TYPE_RAW) {
                $pieces[] = Config::getPropertyTypeName($type);
                $pieces[] = Config::getEntityName($type, $entity);
                $pieces[] = Config::getPropertyName($type, $entity, $property);
            }

            $pieces[] = implode(', ', (array) $data['value']);

            $pieces = array_filter($pieces);

            return implode('.', $pieces);
        };

        $propertyA = $getPropertyText(array_get($this->condition, 'propertyA', []));
        $propertyB = $getPropertyText(array_get($this->condition, 'propertyB', []));
        $assertion = Config::getAssertionName(array_get($this->condition, 'assertion', ''));

        return "[{$propertyA}] {$assertion} [{$propertyB}]";
    }

    /**
     * @inheritdoc
     */
    public function getTable(): string
    {
        return 'security_rules';
    }

    /**
     * @inheritdoc
     */
    public function getFillable(): array
    {
        return [
            'name',
            'effect',
            'condition',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getCasts(): array
    {
        return [
            'id'        => 'integer',
            'policy_id' => 'integer',
            'name'      => 'string',
            'effect'    => 'string',
            'condition' => 'array',
        ];
    }
}
