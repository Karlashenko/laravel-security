<?php

declare(strict_types=1);

namespace Phrantiques\Security\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Phrantiques\Security\Support\Config;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Policy extends Model
{
    private static $byOperationPolicies = [];

    /**
     * @param mixed  $subject
     * @param mixed  $resource
     * @param string $action
     * @param array  $properties
     *
     * @return Policy[]|Collection
     */
    public static function byOperation($subject, $resource, string $action, array $properties = null): Collection
    {
        $key = sprintf('by_operation_%s_%s_%s_%s', get_class($subject), get_class($resource), $action, implode('_', (array) $properties));

        if (array_get(self::$byOperationPolicies, $key) === null) {
            self::$byOperationPolicies[$key] = self::byProperties($properties)
                ->whereSubject(get_class($subject))
                ->whereResource(get_class($resource))
                ->whereAction($action)
                ->get();
        }

        return array_get(self::$byOperationPolicies, $key);
    }

    public function scopeByProperties(Builder $builder, array $properties = null): Builder
    {
        if ($properties === null || count($properties) === 0) {
            return $builder->where('properties', '[""]');
        }

        $properties = array_map(function ($property) {
            return DB::getPdo()->quote((string) $property);
        }, $properties);

        return $builder->whereRaw('jsonb_exists_any(properties, ARRAY [' . implode(',', $properties) . '])');
    }

    public function rules(): BelongsToMany
    {
        return $this->belongsToMany(Rule::class, 'security_policies_rules', 'policy_id', 'rule_id');
    }

    public function getPropertiesAsString(): string
    {
        $resource = $this->resource;

        $properties = array_map(function ($property) use ($resource) {
            return Config::getResourcePropertyName($resource, $property);
        }, $this->properties);

        $properties = array_filter($properties);

        return implode(', ', $properties);
    }

    /**
     * @inheritdoc
     */
    public function getTable(): string
    {
        return 'security_policies';
    }

    /**
     * @inheritdoc
     */
    public function getFillable(): array
    {
        return [
            'name',
            'subject',
            'resource',
            'properties',
            'action',
            'algorithm',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getCasts(): array
    {
        return [
            'id'         => 'integer',
            'name'       => 'string',
            'subject'    => 'string',
            'resource'   => 'string',
            'properties' => 'array',
            'action'     => 'string',
            'algorithm'  => 'string',
        ];
    }
}
