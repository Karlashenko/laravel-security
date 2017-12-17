<?php

namespace Phrantiques\Security\Services;

use Illuminate\Support\Facades\Event;
use Phrantiques\Security\Models\Policy;
use Phrantiques\Security\Core\PolicySet;
use Phrantiques\Security\Core\PolicyFactory;
use Phrantiques\Security\Core\Algorithms\Algorithm;
use Phrantiques\Security\Core\Algorithms\PermitWhenPermittedAndNotDenied;
use Phrantiques\Security\Events\AuthorizationEvent;

class Security
{
    public const EVENT_RULE_EVALUATION            = 'security.rule.evaluation';
    public const EVENT_AUTHORIZATION              = 'security.authorization';

    public const EVALUATION_EFFECT_PERMIT         = 'permit';
    public const EVALUATION_EFFECT_DENY           = 'deny';
    public const EVALUATION_EFFECT_NOT_APPLICABLE = 'not_applicable';
    public const EVALUATION_EFFECT_INDETERMINATE  = 'indeterminate';

    public const PROPERTY_TYPE_RESOURCE           = 'resource';
    public const PROPERTY_TYPE_SUBJECT            = 'subject';
    public const PROPERTY_TYPE_ENVIRONMENT        = 'environment';
    public const PROPERTY_TYPE_RAW                = 'raw';

    public const ACTION_CREATE                    = 'create';
    public const ACTION_DELETE                    = 'delete';
    public const ACTION_EDIT                      = 'edit';
    public const ACTION_READ                      = 'read';

    /**
     * @param mixed     $subject
     * @param mixed     $resource
     * @param string    $action
     * @param array     $properties
     * @param Algorithm $algorithm
     *
     * @return bool
     * @throws \RuntimeException
     * @throws \ReflectionException
     */
    public function isAuthorized($subject, $resource, string $action, array $properties = null, Algorithm $algorithm = null): bool
    {
        $algorithm = $algorithm ?? new PermitWhenPermittedAndNotDenied();

        /** @var \Phrantiques\Security\Core\Policy[] $policies */
        $policies = Policy::byOperation($subject, $resource, $action, $properties);

        $policies = $policies->map(function (Policy $policy) use ($subject, $resource) {
            return PolicyFactory::make($policy, $subject, $resource);
        });

        $policySet = new PolicySet($policies->toArray(), $algorithm);

        $isAuthorized = $policySet->evaluate() === self::EVALUATION_EFFECT_PERMIT;

        $event = new AuthorizationEvent($subject, $resource, $action, $properties, $isAuthorized);
        Event::fire(self::EVENT_AUTHORIZATION, $event);

        return $isAuthorized;
    }
}
