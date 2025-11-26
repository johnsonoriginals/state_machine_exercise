<?php

namespace Tests\unit\validators;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use cjohnson\validators\SimpleConfigValidator;
use cjohnson\factory\StateMachineConfig;

/**
 * Class SimpleConfigValidatorTest
 */
#[CoversClass(\cjohnson\validators\SimpleConfigValidator::class)]
final class SimpleConfigValidatorTest extends TestCase
{
    /**
     * Test that validate returns true for a valid configuration.
     *
     * @return void
     */
    public function testValidateReturnsTrueForValidConfig(): void
    {
        // Arrange.
        $config = $this->createMock(StateMachineConfig::class);
        $config->method('getStates')->willReturn(['s1', 's2']);
        $config->method('getFinalStates')->willReturn(['s1', 's2']);
        $config->method('getAlphabet')->willReturn(['a', 'b']);
        $config->method('getTransitions')->willReturn([['s1', 'a', 's2']]);
        $config->method('getDefaultState')->willReturn('s1');

        // Act.
        $validator = new SimpleConfigValidator();

        // Assert.
        $this->assertInstanceOf(SimpleConfigValidator::class, $validator);
        $this->assertTrue($validator->validate($config));
    }

    /**
     * Test that validate returns false for missing states.
     *
     * @return void
     */
    public function testValidateReturnsFalseForMissingStates(): void
    {
        // Arrange.
        $config = $this->createMock(StateMachineConfig::class);
        $config->method('getStates')->willReturn([]); // invalid: fewer than MINIMUM_STATES
        $config->method('getFinalStates')->willReturn([]);
        $config->method('getAlphabet')->willReturn([]);
        $config->method('getTransitions')->willReturn([]);
        $config->method('getDefaultState')->willReturn('');

        // Act.
        $validator = new SimpleConfigValidator();

        // Assert.
        $this->assertInstanceOf(SimpleConfigValidator::class, $validator);
        $this->assertFalse($validator->validate($config));
    }

    /**
     * Test that validate returns false when final states are not a subset of states.
     *
     * @return void
     */
    public function testValidateReturnsFalseWhenFinalStatesNotSubsetOfStates(): void
    {
        // Arrange.
        $config = $this->createMock(StateMachineConfig::class);
        $config->method('getStates')->willReturn(['s1', 's2']);
        $config->method('getFinalStates')->willReturn(['s1', 'unknown']); // 'unknown' not in states
        $config->method('getAlphabet')->willReturn(['a', 'b']);
        $config->method('getTransitions')->willReturn([['s1', 'a', 's2']]);
        $config->method('getDefaultState')->willReturn('s1');

        // Act.
        $validator = new SimpleConfigValidator();

        // Assert.
        $this->assertFalse($validator->validate($config));
    }

    /**
     * Test that validate returns false for invalid transitions structure.
     *
     * @return void
     */
    public function testValidateReturnsFalseForInvalidTransitionsStructure(): void
    {
        // Arrange.
        $config = $this->createMock(StateMachineConfig::class);
        $config->method('getStates')->willReturn(['s1', 's2']);
        $config->method('getFinalStates')->willReturn(['s1', 's2']);
        $config->method('getAlphabet')->willReturn(['a', 'b']);
        // invalid transition entry (expects 3 elements per item)
        $config->method('getTransitions')->willReturn([['s1', 'a']]);
        $config->method('getDefaultState')->willReturn('s1');

        // Act.
        $validator = new SimpleConfigValidator();

        // Assert.
        $this->assertFalse($validator->validate($config));
    }

    /**
     * Test that validate returns false for default state not in states.
     *
     * @return void
     */
    public function testValidateReturnsFalseForDefaultStateNotInStates(): void
    {
        // Arrange.
        $config = $this->createMock(StateMachineConfig::class);
        $config->method('getStates')->willReturn(['s1', 's2']);
        $config->method('getFinalStates')->willReturn(['s1', 's2']);
        $config->method('getAlphabet')->willReturn(['a', 'b']);
        $config->method('getTransitions')->willReturn([['s1', 'a', 's2']]);
        $config->method('getDefaultState')->willReturn('unknown'); // not in states

        // Act.
        $validator = new SimpleConfigValidator();

        // Assert.
        $this->assertFalse($validator->validate($config));
    }
}
