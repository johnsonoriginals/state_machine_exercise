<?php

namespace Tests\unit\enumerations;

use cjohnson\enumerations\StateMachineEnum;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * Class StateMachineEnumTest
 */
#[CoversClass(\cjohnson\enumerations\StateMachineEnum::class)]
final class StateMachineEnumTest extends TestCase
{
    /**
     * Test S0 state transitions.
     *
     * @return void
     */
    public function testS0Transitions()
    {
        $s0 = StateMachineEnum::S0;

        // S0 with S1 -> S1
        $this->assertEquals(StateMachineEnum::S1, $s0->transitionTo(StateMachineEnum::S1));

        // S0 with S0 -> S0
        $this->assertEquals(StateMachineEnum::S0, $s0->transitionTo(StateMachineEnum::S0));
    }

    /**
     * Test S1 state transitions.
     *
     * @return void
     */
    public function testS1Transitions()
    {
        $s1 = StateMachineEnum::S1;

        // S1 with S0 -> S2
        $this->assertEquals(StateMachineEnum::S2, $s1->transitionTo(StateMachineEnum::S0));

        // S1 with S1 -> S0
        $this->assertEquals(StateMachineEnum::S0, $s1->transitionTo(StateMachineEnum::S1));
    }

    /**
     * Test S2 state transitions.
     *
     * @return void
     */
    public function testS2Transitions()
    {
        $s2 = StateMachineEnum::S2;

        // S2 with S0 -> S1
        $this->assertEquals(StateMachineEnum::S1, $s2->transitionTo(StateMachineEnum::S0));

        // S2 with S1 -> S2
        $this->assertEquals(StateMachineEnum::S2, $s2->transitionTo(StateMachineEnum::S1));
    }
}
