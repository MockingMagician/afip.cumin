<?php

namespace Mmatweb\Cumin;


class Item
{
    private $id;
    private $price;
    private $description;
    private $quantity;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function __construct(int $id, float $price, string $description)
    {
        $this->id = $id;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = 1;
    }

    public function addOne(): self
    {
        $this->quantity++;

        return $this;
    }

    public function removeOne(): self
    {
        if ($this->quantity <= 0) {
            return $this;
        }

        $this->quantity--;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}