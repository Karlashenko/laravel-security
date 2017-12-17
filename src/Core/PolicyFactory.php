<?php

declare(strict_types=1);

namespace Phrantiques\Security\Core;

use Phrantiques\Security\Models\Policy as PolicyModel;
use Phrantiques\Security\Core\Hydrators\ConditionHydrator;
use Phrantiques\Security\Core\Algorithms\AlgorithmFactory;

class PolicyFactory
{
    /**
     * @param PolicyModel $policyModel
     * @param mixed       $subject
     * @param mixed       $resource
     *
     * @return Policy
     * @throws \RuntimeException
     * @throws \ReflectionException
     */
    public static function make(PolicyModel $policyModel, $subject, $resource): Policy
    {
        $conditionHydrator = new ConditionHydrator($subject, $resource);

        $rules = [];

        foreach ($policyModel->rules as $ruleModel) {
            $condition = new Condition();
            $conditionHydrator->hydrate($ruleModel->condition, $condition);

            $rule = new Rule();
            $rule->setCondition($condition);
            $rule->setEffect($ruleModel->effect);

            $rules[] = $rule;
        }

        $policy = new Policy();
        $policy->setAction($policyModel->action);
        $policy->setAlgorithm(AlgorithmFactory::make($policyModel->algorithm));
        $policy->setResource($resource);
        $policy->setSubject($subject);
        $policy->setRules($rules);

        return $policy;
    }
}
