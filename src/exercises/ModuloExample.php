<?php

declare(strict_types=1);

namespace cjohnson\exercises;

use cjohnson\enumerations\StateMachineEnum;
use cjohnson\factory\StateMachine;
use cjohnson\factory\StateMachineFactory;
use cjohnson\factory\StateMachineConfig;
use Psr\Log\LoggerInterface;

/**
 * Class ModuloExample
 *
 * This class provides a method to compute the modulo 3 (x % 3) of a sequence of binary digits (1 and 0's)
 * represented as a string using a state machine approach instead of using the % operator.
 */
class ModuloExample
{
    /**
     * Calculates the modulo 3 of a binary number represented as a string using an enumeration-based state machine.
     *  This satisfies the standard exercise requirement.
     *
     * @param string $number The binary number as a string.
     *   the binary number as a string.
     * @return int The result of the modThree operation (0 or 1).
     *   the result of the modThree operation (0, 1, or 2).
     */
    public function modThreeByEnum(string $number): int
    {
        $state = StateMachineEnum::S0;
        $characters = str_split($number);
        foreach ($characters as $character) {
            $state = $state->transitionTo(StateMachineEnum::from((int)$character));
        }
        return $state->value;
    }

    /**
     * Calculates the modulo 3 of a binary number represented as a string using the state machine class directly.
     *  This partially satisfies the advanced exercise requirement.
     *
     * @param string $number
     *   the binary number as a string.
     * @return int
     *   The result of the modThree operation (0, 1, or 2).
     */
    public function modThreeByMachine(string $number): int
    {
        $states = ['S0', 'S1', 'S2'];
        $finalStates = ['S0', 'S1', 'S2'];
        $alphabet = [0, 1];
        $stateTransitions = [
            ["S0", 0, "S0"],
            ["S0", 1, "S1"],
            ["S1", 0, "S2"],
            ["S1", 1, "S0"],
            ["S2", 0, "S1"],
            ["S2", 1, "S2"],
        ];
        $defaultState = "S0";

        $machine = new StateMachine($states, $finalStates, $alphabet, $stateTransitions, $defaultState);

        $characters = str_split($number);
        foreach ($characters as $character) {
            $machine->transitionTo((int)$character);
        }

        $currentState = $machine->getCurrentState();

        return match ($currentState) {
            'S0' => 0,
            'S1' => 1,
            'S2' => 2,
            default => 0,
        };
    }

    /**
     * Calculates the modulo 3 of a binary number represented as a string using the factory class directly.
     *  This completes the advanced exercise requirement.
     *
     * @param string $number
     *   the binary number as a string.
     * @return int
     *   The result of the modThree operation (0, 1, or 2).
     */
    public function modThreeByFactory(string $number, LoggerInterface $logger = null): int
    {
        $config = [
            'states' => ['S0', 'S1', 'S2'],
            'finalStates' => ['S0', 'S1', 'S2'],
            'alphabet' => [0, 1],
            'stateTransitions' => [
                ["S0", 0, "S0"],
                ["S0", 1, "S1"],
                ["S1", 0, "S2"],
                ["S1", 1, "S0"],
                ["S2", 0, "S1"],
                ["S2", 1, "S2"],
            ],
            'defaultState' => "S0",
        ];

        $machineConfig = new StateMachineConfig($config);
        $builtMachine = (new StateMachineFactory($machineConfig, $logger))->build();
        $characters = str_split($number);
        if ($builtMachine) {
            foreach ($characters as $character) {
                $builtMachine->transitionTo((int)$character);
            }
            $currentState = $builtMachine->getCurrentState();
        } else {
            // If the machine could not be built, default to state S0.
            $currentState = 'S0';
        }

        return match ($currentState) {
            'S0' => 0,
            'S1' => 1,
            'S2' => 2,
            default => 0,
        };
    }
}
