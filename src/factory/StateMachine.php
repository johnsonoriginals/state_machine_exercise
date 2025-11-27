<?php

declare(strict_types=1);

namespace cjohnson\factory;

/**
 * Class StateMachine
 *
 * This class is responsible for representing a state machine that can be used to manage application workflows.
 */
class StateMachine
{
    /**
     * Class property for the possible states of the machine.
     *
     * @var array<int|string>
     */
    protected array $states = [];

    /**
     * Class property for the possible final states of the machine.
     *
     * @var array<string>
     */
    protected array $finalStates = [];

    /**
     * Class property for the input alphabet that may be used in state transitions.
     *
     * @var array<int>
     */
    protected array $alphabet = [];

    /**
     * Class property for the state transitions of the machine.
     *
     * @var array<array<string|int>>
     */
    protected array $stateTransitions = [];

    /**
     * Class property for the default state of the machine.
     *
     * @var string
     *
     */
    protected string $defaultState = "";

    /**
     * Class property for the current state of the machine.
     *
     * @var mixed
     */
    protected mixed $currentState = "";

    /**
     * Default constructor.
     *
     * @param array<string> $states
     *   array of possible states, for example: ['pending', 'approved', 'rejected']
     * @param array<string> $finalStates
     *   array of final states, for example: ['approved', 'rejected']
     * @param array<int> $alphabet
     *  array of valid alphabet inputs, for example: [0, 1]
     * @param array<int, list<int|string>> $stateTransitions
     *  array of state transitions, for example: [['pending', 1, 'approved'], ['pending', 0, 'rejected']]
     * @param string $defaultState
     *   the default state of the machine, for example: 'pending'
     */
    public function __construct(
        array $states = [],
        array $finalStates = [],
        array $alphabet = [],
        array $stateTransitions = [],
        string $defaultState = ""
    ) {
        $this->states = $states;
        $this->finalStates = $finalStates;
        $this->alphabet = $alphabet;
        $this->stateTransitions = $stateTransitions;
        $this->defaultState = $defaultState;
    }

    /**
     * Transitions the machine to a new state based on the input state.
     *
     * @param int $inputState
     *   The input state to transition to.
     * @return mixed
     *   The new current state after the transition.
     */
    public function transitionTo(int $inputState): mixed
    {
        foreach ($this->stateTransitions as $transition) {
            if ($transition[0] === $this->getCurrentState() && $transition[1] === $inputState) {
                $this->currentState = $transition[2];
                return $this->currentState;
            }
        }
        return $this->currentState; // No valid transition found, return current state
    }

    /**
     * Gets the current state of the machine.
     *
     * @return string
     *   The current state of the machine.
     */
    public function getCurrentState(): string
    {
        if (!empty($this->currentState)) {
            return $this->currentState;
        }
        $defaultStateKey = array_search($this->defaultState, $this->states);

        $this->setCurrentState($this->states[$defaultStateKey]);
        return $this->currentState;
    }

    /**
     * Sets the current state of the machine.
     *
     * @param mixed $state
     *   The state to set as the current state.
     * @return void
     */
    public function setCurrentState(mixed $state): void
    {
        $this->currentState = $state;
    }
}
