<?php

declare(strict_types=1);

namespace Phrantiques\Security\Events;

class AuthorizationEvent
{
    /**
     * @var mixed
     */
    private $subject;

    /**
     * @var mixed
     */
    private $resource;

    /**
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $properties;

    /**
     * @var string
     */
    private $decision;

    /**
     * Create a new AuthorizationEvent instance.
     *
     * @param mixed  $subject
     * @param mixed  $resource
     * @param string $action
     * @param string $properties
     * @param string $decision
     */
    public function __construct($subject, $resource, string $action, array $properties = null, string $decision)
    {
        $this->subject = $subject;
        $this->resource = $resource;
        $this->action = $action;
        $this->properties = (array) $properties;
        $this->decision = $decision;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @return string
     */
    public function getDecision(): string
    {
        return $this->decision;
    }
}
