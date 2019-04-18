<?php

namespace Mmatweb\Cumin\Tests;

use Mmatweb\Cumin\BackEndInterface;
use Mmatweb\Cumin\BackEndNotDefinedException;
use Mmatweb\Cumin\Cart;
use Mmatweb\Cumin\Item;
use Mmatweb\Cumin\NotSameItemPriceException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * @internal
 * @coversNothing
 */
final class CartTest extends TestCase
{
    /** @var Cart */
    public $cart;
    /** @var Item */
    public $ItemOne;
    /** @var Item */
    public $ItemTwo;
    /** @var Item */
    public $ItemOneWithBadPrice;
    /** @var BackEndInterface|ObjectProphecy */
    private $backEnd;

    protected const SESSION_ID = 'abc';

    protected function setUp(): void
    {
        $this->backEnd = $this->prophesize(BackEndInterface::class);
        $this->cart = new Cart(null);
        $this->ItemOne = new Item(uniqid('item'), 1.11, '');
        $this->ItemTwo = new Item(uniqid('item'), 2.22, '');
        $this->ItemOneWithBadPrice = new Item($this->ItemOne->getId(), 1.22, '');
    }

    /**
     * @throws BackEndNotDefinedException
     */
    public function test save throw exception if backEnd is not defined()
    {
        $this->expectException(BackEndNotDefinedException::class);

        $this->cart->save(self::SESSION_ID);
    }

    /**
     * @throws BackEndNotDefinedException
     */
    public function test save work()
    {
        $this->backEnd
            ->write(Argument::exact(self::SESSION_ID), Argument::any())
            ->shouldBeCalledOnce()
            ->willReturn(true)
        ;
        $this->cart = new Cart($this->backEnd->reveal());

        $this->cart->save(self::SESSION_ID);
    }

    public function test get cart from backEnd()
    {
        $this->backEnd
            ->read(Argument::exact(self::SESSION_ID))
            ->shouldBeCalledOnce()
            ->willReturn(serialize(new Cart(null)))
        ;

        $this->assertInstanceOf(Cart::class, Cart::getCart($this->backEnd->reveal(), self::SESSION_ID));
    }

    /**
     * @throws \Mmatweb\Cumin\NotSameItemPriceException
     */
    public function test cart add one so count one in count and item()
    {
        $this->cart->addItem($this->ItemOne);

        $this->assertSame(1, $this->cart->getCount());
        $this->assertSame(1, $this->cart->getItemsCount());
    }

    /**
     * @throws \Mmatweb\Cumin\NotSameItemPriceException
     */
    public function test cart add one then remove so count zero in count and item()
    {
        $this->cart->addItem($this->ItemOne);

        $this->assertSame(1, $this->cart->getCount());
        $this->assertSame(1, $this->cart->getItemsCount());

        $this->cart->removeItem($this->ItemOne);

        $this->assertSame(0, $this->cart->getCount());
        $this->assertSame(0, $this->cart->getItemsCount());
    }

    /**
     * @throws \Mmatweb\Cumin\NotSameItemPriceException
     */
    public function test cart add one so count one()
    {
        $this->cart->addItem($this->ItemOne);

        $this->assertSame(1, $this->cart->getCount());
    }

    /**
     * @throws \Mmatweb\Cumin\NotSameItemPriceException
     */
    public function test cart add another existing one so count two and one item()
    {
        $this->cart->addItem($this->ItemOne)->addItem($this->ItemOne);

        $this->assertSame(2, $this->cart->getCount());
        $this->assertSame(1, $this->cart->getItemsCount());
    }

    /**
     * @throws \Mmatweb\Cumin\NotSameItemPriceException
     */
    public function test cart add two different item so count two and two item()
    {
        $this->cart->addItem($this->ItemOne);
        $this->cart->addItem($this->ItemTwo);

        $this->assertSame(2, $this->cart->getCount());
        $this->assertSame(2, $this->cart->getItemsCount());

        return $this->cart;
    }

    /**
     * @throws \Mmatweb\Cumin\NotSameItemPriceException
     * @depends test cart add two different item so count two and two item
     */
    public function test cart clear(Cart $cart)
    {
        $this->assertSame(2, $cart->getCount());
        $this->assertSame(2, $cart->getItemsCount());

        $cart->clear();

        $this->assertSame(0, $cart->getCount());
        $this->assertSame(0, $cart->getItemsCount());
    }

    /**
     * @throws \Mmatweb\Cumin\NotSameItemPriceException
     */
    public function test cart total amount()
    {
        $i = ($j = 10) * 2;

        $totalExpected = $i * $this->ItemOne->getPrice() + $j * $this->ItemTwo->getPrice();

        while (0 < $i--) {
            $this->cart->addItem($this->ItemOne);
        }

        while (0 < $j--) {
            $this->cart->addItem($this->ItemTwo);
        }

        $this->assertEquals($totalExpected, $this->cart->getTotalAmount());
    }

    /**
     * @throws \Mmatweb\Cumin\NotSameItemPriceException
     */
    public function test cart exception on same item has different price()
    {
        $this->expectException(NotSameItemPriceException::class);

        $this->cart->addItem($this->ItemOne);
        $this->cart->addItem($this->ItemOneWithBadPrice);
    }
}
