<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;

class ProductTest extends TestCase
{
    private Product $product;

    protected function setUp(): void
    {
        $this->product = new Product('Apple', ['USD' => 1.0, 'EUR' => 0.9], 'food');
    }

    public function testGetName(): void
    {
        $this->assertEquals('Apple', $this->product->getName());
    }

    public function testGetPrices(): void
    {
        $this->assertEquals(['USD' => 1.0, 'EUR' => 0.9], $this->product->getPrices());
    }

    public function testGetPrice(): void
    {
        $this->assertEquals(1.0, $this->product->getPrice('USD'));
        $this->assertEquals(0.9, $this->product->getPrice('EUR'));
    }

    public function testGetType(): void
    {
        $this->assertEquals('food', $this->product->getType());
    }

    public function testListCurrencies(): void
    {
        $this->assertEquals(['USD', 'EUR'], $this->product->listCurrencies());
    }
}