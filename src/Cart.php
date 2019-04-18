<?php

namespace Mmatweb\Cumin;

class Cart
{
    /** @var Item[] */
    private $items = [];
    private $id;
    private $backEnd;

    public function __construct(?BackEndInterface $backEnd)
    {
        try {
            $this->id = uniqid('cart_').'_'.random_bytes(12);
        } catch (\Exception $e) {
            $this->id = uniqid('cart_').'_'.rand(999, 999999);
        }
        $this->backEnd = $backEnd;
    }

    public static function getCart(BackEndInterface $backEnd, $id): self
    {
        return unserialize($backEnd->read($id));
    }

    /**
     * @param Item $item
     *
     * @throws NotSameItemPriceException
     *
     * @return Cart
     */
    public function addItem(Item $item): self
    {
        if (!isset($this->items[$item->getId()])) {
            $this->items[$item->getId()] = $item;

            return $this;
        }

        $recordedItem = $this->items[$item->getId()];

        if ($recordedItem->getPrice() !== $item->getPrice()) {
            throw new NotSameItemPriceException();
        }

        $recordedItem->addOne();

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if (!isset($this->items[$item->getId()])) {
            return $this;
        }

        $this->items[$item->getId()]->removeOne();

        if (0 === $this->items[$item->getId()]->getQuantity()) {
            unset($this->items[$item->getId()]);
        }

        return $this;
    }

    public function getItemsCount(): int
    {
        return \count($this->items);
    }

    public function getCount(): int
    {
        $i = 0;

        foreach ($this->items as $currentItem) {
            $i += $currentItem->getQuantity();
        }

        return $i;
    }

    public function getTotalAmount(): float
    {
        $i = 0.0;

        foreach ($this->items as $currentItem) {
            $i += $currentItem->getPrice() * $currentItem->getQuantity();
        }

        return $i;
    }

    public function clear(): self
    {
        $this->items = [];

        return $this;
    }

    public function getItem(int $id): ?Item
    {
        return $this->items[$id] ?? null;
    }

    public function getIterator(): ItemsIterator
    {
        return new ItemsIterator($this);
    }
}
