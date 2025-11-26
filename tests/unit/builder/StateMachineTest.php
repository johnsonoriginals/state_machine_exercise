<?php

namespace Tests\unit\builder;

use cjohnson\factory\StateMachine;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Class StateMachineTest
 */
#[CoversClass(\cjohnson\factory\StateMachine::class)]
final class StateMachineTest extends TestCase
{
    /**
     * Test that the StateMachine constructor creates an instance successfully.
     *
     * @return void
     */
    public function testStateMachineConstructor(): void
    {
        // Arrange.
        // Arrange.
        $testParams = [
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

        // Act.
        $machineUnderTest = new StateMachine(
            $testParams['states'],
            $testParams['finalStates'],
            $testParams['alphabet'],
            $testParams['stateTransitions'],
            $testParams['defaultState']
        );

        // Assert.
        $this->assertInstanceOf(StateMachine::class, $machineUnderTest);
    }

    /**
     * Test that the StateMachine constructor fails with invalid parameters.
     *
     * @return void
     */
    public function testStateMachineConstructorFailure(): void
    {
        // Arrange.
        $testParams = -1;

        // Act & Assert.
        $this->expectException(\TypeError::class);
        $machineUnderTest = new StateMachine($testParams);
    }

    /**
     * Test state transitions for described scenarios.
     *
     * @param string $initialState
     * @param int $inputSymbol
     * @param string $expected
     * @param array $states
     * @param array $finalStates
     * @param array $alphabet
     * @param array $stateTransitions
     * @param string $defaultState
     * @return void
     */
    #[DataProvider("stateTransitionScenarioProvider")]
    public function testStateTransitions(
        string $initialState,
        int $inputSymbol,
        string $expected,
        array $states,
        array $finalStates,
        array $alphabet,
        array $stateTransitions,
        string $defaultState
    ): void {
        // Arrange.
        $machineUnderTest = new StateMachine($states, $finalStates, $alphabet, $stateTransitions, $defaultState);

        // Act.
        $machineUnderTest->setCurrentState($initialState);

        // Assert.
        $this->assertSame($expected, $machineUnderTest->transitionTo($inputSymbol));
    }

    /**
     * Test that invalid input returns the current state when StateMachine is created with valid parameters
     * when starting from the default state.
     *
     * @return void
     */
    public function testInvalidInputReturnsCurrentStateFromDefaultState(): void
    {
        // Arrange.
        $testParams = [
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

        // Act.
        $machineUnderTest = new StateMachine(
            $testParams['states'],
            $testParams['finalStates'],
            $testParams['alphabet'],
            $testParams['stateTransitions'],
            $testParams['defaultState']
        );

        // Assert.
        // invalid symbol should return the current state (initially "S0")
        $this->assertSame('S0', $machineUnderTest->transitionTo("2"));
    }

    /**
     * Test that invalid input returns the current state when StateMachine is created with valid parameters
     * when starting from a non-default state.
     *
     * @return void
     */
    public function testInvalidInputReturnsCurrentStateFromANonDefaultState(): void
    {
        // Arrange.
        $testParams = [
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

        // Act.
        $machineUnderTest = new StateMachine(
            $testParams['states'],
            $testParams['finalStates'],
            $testParams['alphabet'],
            $testParams['stateTransitions'],
            $testParams['defaultState']
        );
        $machineUnderTest->transitionTo(1); // Move to "S1"

        // Assert.
        // invalid symbol should return the current state ("S1" after setting it)
        $this->assertSame('S1', $machineUnderTest->transitionTo("2"));
    }

    /**
     * Data provider for state transition scenarios.
     *
     * @return array[]
     */
    public static function stateTransitionScenarioProvider(): array
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
        $scenarios = [
            's0->s0' => ['S0', 0, 'S0', $states, $finalStates, $alphabet, $stateTransitions, $defaultState],
            's0->s1' => ['S0', 1, 'S1', $states, $finalStates, $alphabet, $stateTransitions, $defaultState],
            's1->s2' => ['S1', 0, 'S2', $states, $finalStates, $alphabet, $stateTransitions, $defaultState],
            's1->s0' => ['S1', 1, 'S0', $states, $finalStates, $alphabet, $stateTransitions, $defaultState],
            's2->s1' => ['S2', 0, 'S1', $states, $finalStates, $alphabet, $stateTransitions, $defaultState],
            's2->s2' => ['S2', 1, 'S2', $states, $finalStates, $alphabet, $stateTransitions, $defaultState],
        ];
        return $scenarios;
    }
}
