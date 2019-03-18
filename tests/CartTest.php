<?php

namespace Mmatweb\Cumin\Tests;

use Mmatweb\Cumin\BackEndInterface;
use Mmatweb\Cumin\Cart;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CartTest extends TestCase
{
    /** @var Cart */
    public $cart;

    protected function setUp(): void
    {
        $backEnd = $this->createMock(BackEndInterface::class);
        $this->cart = new Cart($backEnd->reveal());
    }

    public function test cart set up correctly()
    {

    }
}
