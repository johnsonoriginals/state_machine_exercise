<?php

declare(strict_types=1);

namespace tests\unit\builder;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use cjohnson\factory\StateMachineFactory;
use cjohnson\factory\StateMachineConfig;
use cjohnson\factory\StateMachine;
use Psr\Log\LoggerInterface;

/**
 * Class StateMachineFactoryTest
 *   Unit tests for the StateMachineFactory class.
 *
 */
#[CoversClass(\cjohnson\factory\StateMachineFactory::class)]
final class StateMachineFactoryTest extends TestCase
{
    /**
     * Test that build method returns a StateMachine instance when provided configuration is valid.
     *
     * @return void
     */
    public function testBuildReturnsStateMachineWhenConfigValid(): void
    {
        // Arrange.
        $config = $this->createMock(StateMachineConfig::class);
        $config->method('getStates')->willReturn(['S0', 'S1', 'S2']);
        $config->method('getFinalStates')->willReturn(['S0', 'S1', 'S2']);
        $config->method('getAlphabet')->willReturn([0, 1]);
        $config->method('getTransitions')->willReturn([
            ["S0", 0, "S0"],
            ["S0", 1, "S1"],
            ["S1", 0, "S2"],
            ["S1", 1, "S0"],
            ["S2", 0, "S1"],
            ["S2", 1, "S2"],
        ]);
        $config->method('getDefaultState')->willReturn('S0');

        $logger = $this->createMock(LoggerInterface::class);

        // Act.
        $factory = new StateMachineFactory($config, $logger);
        $machine = $factory->build();

        // Assert.
        $this->assertInstanceOf(StateMachine::class, $machine);

        // Simple check on the factory constructed machine
        $this->assertSame("S0", $machine->getCurrentState());
    }

    /**
     * Test that build method returns null and logs an error when provided configuration is invalid.
     *
     * @return void
     */
    public function testBuildReturnsNullAndLogsWhenConfigInvalid(): void
    {
        // Arrange.
        $config = $this->createMock(StateMachineConfig::class);
        $config->method('getStates')->willReturn([]); // invalid config: no states
        $config->method('getFinalStates')->willReturn([]);
        $config->method('getAlphabet')->willReturn([]);
        $config->method('getTransitions')->willReturn([]);
        $config->method('getDefaultState')->willReturn('');

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->any())
            ->method('error')
            ->withAnyParameters();

        // Act.
        $factory = new StateMachineFactory($config, $logger);

        // Assert.
        $this->assertNull($factory->build());
    }

    /**
     * Test that the StateMachine constructor fails with invalid parameters.
     *
     * @return void
     */
    public function testStateMachineFactoryConstructorFailure(): void
    {
        // Arrange.
        $testParams = -1;

        // Act & Assert.
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore argument.type */
        $machineUnderTest = new StateMachineFactory($testParams, null);
    }
}
