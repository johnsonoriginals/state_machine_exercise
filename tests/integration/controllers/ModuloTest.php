<?php

namespace Tests\integration\controllers;

use cjohnson\exercises\ModuloExample;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use ValueError;

/**
 * Class ModuloTest
 *
 */
#[CoversClass(ModuloExample::class)]
final class ModuloTest extends TestCase
{
    /**
     * Test standard exercise with single digit inputs.
     *
     * @return void
     */
    public function testStandardExerciseSingleDigit()
    {
        // Act.
        $moduloUnderTest = new ModuloExample();

        // Assert.
        $this->assertSame(0, $moduloUnderTest->modThreeByEnum('0'));
        $this->assertSame(1, $moduloUnderTest->modThreeByEnum('1'));
    }

    /**
     * Test advanced exercise with single digit inputs using only the state machine class directly.
     *
     * @return void
     */
    public function testAdvancedExerciseSingleDigit()
    {
        // Act.
        $moduloUnderTest = new ModuloExample();

        // Assert.
        $this->assertSame(0, $moduloUnderTest->modThreeByMachine('0'));
        $this->assertSame(1, $moduloUnderTest->modThreeByMachine('1'));
    }

    /**
     * Test advanced exercise with single digit inputs using the factory method.
     *
     * @return void
     */
    public function testAdvancedExerciseSingleDigitWithFactory()
    {
        // Arrange.
        $logger = $this->createMock(LoggerInterface::class);

        // Act.
        $moduloUnderTest = new ModuloExample();

        // Assert.
        $this->assertSame(0, $moduloUnderTest->modThreeByFactory('0', $logger));
        $this->assertSame(1, $moduloUnderTest->modThreeByFactory('1', $logger));
    }

    /**
     * Test standard exercise with multiple digit inputs.
     *
     * @return void
     */
    public function testStandardExerciseMultipleDigits()
    {
        // Act.
        $moduloUnderTest = new ModuloExample();

        // Assert.
        $this->assertSame(0, $moduloUnderTest->modThreeByEnum('110'));
        $this->assertSame(1, $moduloUnderTest->modThreeByEnum('1010'));
        $this->assertSame(0, $moduloUnderTest->modThreeByEnum('11111111'));
    }

    /**
     * Test advanced exercise with multiple digit inputs using the state machine class directly.
     *
     * @return void
     */
    public function testAdvancedExerciseMultipleDigits()
    {
        // Act.
        $moduloUnderTest = new ModuloExample();

        // Assert.
        $this->assertSame(0, $moduloUnderTest->modThreeByMachine('110'));
        $this->assertSame(1, $moduloUnderTest->modThreeByMachine('1010'));
        $this->assertSame(0, $moduloUnderTest->modThreeByMachine('11111111'));
    }

    /**
     * Test advanced exercise with multiple digit inputs using the factory method.
     *
     * @return void
     */
    public function testAdvancedExerciseMultipleDigitsWithFactory()
    {
        // Arrange.
        $logger = $this->createMock(LoggerInterface::class);

        // Act.
        $moduloUnderTest = new ModuloExample();

        // Assert.
        $this->assertSame(0, $moduloUnderTest->modThreeByFactory('110', $logger));
        $this->assertSame(1, $moduloUnderTest->modThreeByFactory('1010', $logger));
        $this->assertSame(0, $moduloUnderTest->modThreeByFactory('11111111', $logger));
    }

    /**
     * Test standard exercise with empty string input.
     *
     * @return void
     */
    public function testStandardExerciseEmptyStringReturnsZero()
    {
        // Act.
        $moduloUnderTest = new ModuloExample();

        // Assert.
        $this->assertSame(0, $moduloUnderTest->modThreeByEnum(''));
    }

    /**
     * Test advanced exercise with empty string input with the state machine class directly.
     *
     * @return void
     */
    public function testAdvancedExerciseEmptyStringReturnsZero()
    {
        // Act
        $moduloUnderTest = new ModuloExample();

        // Assert.
        $this->assertSame(0, $moduloUnderTest->modThreeByMachine(''));
    }

    /**
     * Test advanced exercise with empty string input using the factory method.
     *
     * @return void
     */
    public function testAdvancedExerciseEmptyStringReturnsZeroWithFactory()
    {
        // Arrange.
        $logger = $this->createMock(LoggerInterface::class);

        // Act.
        $moduloUnderTest = new ModuloExample();

        // Assert.
        $this->assertSame(0, $moduloUnderTest->modThreeByFactory('', $logger));
    }
    /**
     * Test standard exercise with invalid digit input.
     *
     * @return void
     */
    public function testStandardExerciseInvalidDigitThrowsValueError()
    {
        // Arrange
        $this->expectException(ValueError::class);

        // Act.
        $moduloUnderTest = new ModuloExample();

        // Assert.
        $moduloUnderTest->modThreeByEnum('5');
    }

    /**
     * Test advanced exercise with invalid digit input using the state machine class directly.
     *
     * @return void
     */
    public function testAdvancedExerciseInvalidDigitReturnsCurrentState()
    {
        // Arrange.
        $moduloUnderTest = new ModuloExample();

        // Act.
        $result = $moduloUnderTest->modThreeByMachine('5');

        // Assert.
        $this->assertSame(0, $result);
    }

    /**
     * Test advanced exercise with invalid digit input using the factory method.
     *
     * @return void
     */
    public function testAdvancedExerciseInvalidDigitReturnsCurrentStateWithFactory()
    {
        // Arrange.
        $logger = $this->createMock(LoggerInterface::class);
        $moduloUnderTest = new ModuloExample();

        // Act.
        $result = $moduloUnderTest->modThreeByFactory('5', $logger);

        // Assert.
        $this->assertSame(0, $result);
    }
}
