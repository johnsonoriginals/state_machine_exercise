<?php

declare(strict_types=1);

namespace cjohnson\factory;

use cjohnson\contracts\MachineConfigurationContract;

/**
 * Class StateMachineConfig
 *
 * This class is responsible for holding the configuration of a state machine.
 */
class StateMachineConfig implements MachineConfigurationContract
{
    /**
     * Class property for the desired states of the state machine.
     *
     * @var array<string>
     */
    protected array $states = [];

    /**
     * Class property for the desired final states of the state machine.
     * @var array<string>
     */
    protected array $finalStates = [];

    /**
     * Class property for the desired input alphabet of the transitions within the state machine.
     *
     * @var array<int>
     */
    protected array $alphabet = [];

    /**
     * Class property for the desired state transitions of the state machine.
     *
     * @var array<mixed>
     */
    protected array $stateTransitions = [];

    /**
     * Class property for the default state of the state machine.
     *
     * @var string
     */
    protected string $defaultState = "";

    /**
     * Class property for the current state of the state machine.
     *
     * @var string
     */
    protected string $currentState;

    /**
     * Constructor
     *
     * @param array<string, mixed> $config
     *   The configuration for the state machine.
     */
    public function __construct(array $config)
    {
        $this->states = $config['states'] ?? [];
        $this->finalStates = $config['finalStates'] ?? [];
        $this->alphabet = $config['alphabet'] ?? [];
        $this->stateTransitions = $config['stateTransitions'] ?? [];
        $this->defaultState = $config['defaultState'] ?? "";
    }

    /**
     * Accessor for the states property.
     *
     * @return array<string>
     *   The configured states of the state machine.
     */
    public function getStates(): array
    {
        return $this->states;
    }

    /**
     * Accessor for the finalStates property.
     *
     * @return array<mixed>
     *   The configured final states of the state machine.
     */
    public function getFinalStates(): array
    {
        return $this->finalStates;
    }

    /**
     * Accessor for the stateTransitions property.
     *
     * @return array<mixed>
     *   The configured state transitions of the state machine.
     */
    public function getTransitions(): array
    {
        return $this->stateTransitions;
    }

    /**
     * Accessor for the input alphabet property.
     *
     * @return array<int>
     *   The configured input alphabet of the state machine.
     */
    public function getAlphabet(): array
    {
        return $this->alphabet;
    }

    /**
     * Accessor for the defaultState property.
     *
     * @return string
     *   The configured default state of the state machine.
     */
    public function getDefaultState(): string
    {
        return $this->defaultState;
    }
}
