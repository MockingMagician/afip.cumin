<?php

namespace Mmatweb\Cumin\Tests;

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
        $this->cart = new Cart();
    }

    public function test cart set up correctly()
    {
        $this->assertInstanceOf(Cart::class, $this->cart);
    }
}
