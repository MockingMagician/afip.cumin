<?php

namespace Mmatweb\Cumin\Tests;

use Mmatweb\Cumin\Politician;
use Mmatweb\Cumin\PoliticianInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * @internal
 */
final class PoliticianTest extends TestCase
{
    /** @var ObjectProphecy|Politician
     *
     */
    private $centristPolitician;

    protected function setUp(): void
    {
        $this->centristPolitician = $this
            ->prophesize(Politician::class)
            ->willImplement(PoliticianInterface::class)
        ;
    }

    public function test centrist politician vote law()
    {
        $this->centristPolitician->voteLaw(Argument::type('int'))->will(
            function ($args) {
                if (0 === $args[0]) {
                    return true;
                }

                return false;
            }
        );
        $this->assertFalse($this->centristPolitician->reveal()->voteLaw(-1));
        $this->assertTrue($this->centristPolitician->reveal()->voteLaw(0));
        $this->assertFalse($this->centristPolitician->reveal()->voteLaw(-1));
    }
}
