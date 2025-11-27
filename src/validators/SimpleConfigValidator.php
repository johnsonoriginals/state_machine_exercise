<?php

declare(strict_types=1);

namespace cjohnson\validators;

use cjohnson\contracts\MachineConfigurationContract;

/**
 * Class SimpleMachineConfigValidation
 *
 * This class is responsible for validating state machine configurations.
 */
class SimpleConfigValidator
{
    /**
     * Define minimum number of states required.
     */
    protected const MINIMUM_STATES = 1;

    /**
     * Define minimum number of elements in the input alphabet.
     */
    protected const MINIMUM_ALPHABET_SIZE = 2;

    /**
     * Define minimum number of transitions required.
     */
    protected const MINIMUM_TRANSITIONS = 1;

    /**
     * Validate the machine configuration.
     *
     * @param MachineConfigurationContract  $config
     *   the state machine configuration to validate.
     * @return array<bool, array|mixed>
     *   true if the configuration is valid, false otherwise.
     */
    public function validate(MachineConfigurationContract $config): array
    {
        $states = $config->getStates();
        $finalStates = $config->getFinalStates();
        $alphabet = $config->getAlphabet();
        $transitions = $config->getTransitions();
        $defaultState = $config->getDefaultState();
        $result = true;
        $messages = [];

        if (!$this->validateStates($states)) {
            $result = false;
            $messages[] = 'Invalid states configuration.';
        }

        if (!$this->validateFinalStates($finalStates, $states)) {
            $result = false;
            $messages[] = 'Invalid final states configuration.';
        }

        if (!$this->validateAlphabet($alphabet)) {
            $result = false;
            $messages[] = 'Invalid input alphabet configuration.';
        }

        if (!$this->validateTransitions($transitions)) {
            $result = false;
            $messages[] = 'Invalid transitions configuration.';
        }

        if (!$this->validateDefaultState($defaultState, $states)) {
            $result = false;
            $messages[] = 'Invalid default state configuration.';
        }

        return [$result, $messages];
    }
    /**
     * Validate the states array.
     *
     * @param array<string> $states
     *   the array of states to validate.
     * @return bool
     *   true if the states array is valid, false otherwise.
     */
    protected function validateStates(array $states): bool
    {

        if (count($states) < self::MINIMUM_STATES) {
            return false;
        }

        return true;
    }

    /**
     * Validate the final states array.
     *
     * @param array<string> $finalStates
     *   the array of final states to validate.
     * @param array<string> $states
     *   the array of all implemented states.
     * @return bool
     *   true if the final states array is valid, false otherwise.
     */
    protected function validateFinalStates(array $finalStates, array $states): bool
    {
        if (count($finalStates) < self::MINIMUM_STATES) {
            return false;
        }

        $diff = array_diff($finalStates, $states);
        if (empty($diff)) {
            return true;
        }

        return false;
    }

    /**
     * Validate the alphabet array.
     *
     * @param array<int> $alphabet
     *   the array of input alphabet symbols to validate.
     * @return bool
     *   true if the input alphabet array is valid, false otherwise.
     */
    protected function validateAlphabet(array $alphabet): bool
    {
        if (count($alphabet) < self::MINIMUM_ALPHABET_SIZE) {
            return false;
        }

        return true;
    }

    /**
     * Validate the transitions string.
     *
     * @param array<array<string|int>> $transitions
     *   the array of transitions to validate.
     * @return bool
     *   true if the transitions array is valid, false otherwise.
     */
    protected function validateTransitions(array $transitions): bool
    {
        if (count($transitions) < self::MINIMUM_TRANSITIONS) {
            return false;
        }
        foreach ($transitions as $item) {
            if (count($item) !== 3) {
                return false;
            }
        }
        return true;
    }

    /**
     * Validate the default state.
     *
     * @param string $defaultState
     *   the default state to validate.
     * @param array<string> $states
     *   the array of all implemented states.
     * @return bool
     *   true if the default state is valid, false otherwise.
     */
    protected function validateDefaultState(string $defaultState, array $states): bool
    {
        return in_array($defaultState, $states, true);
    }
}
