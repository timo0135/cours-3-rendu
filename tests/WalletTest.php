<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Wallet;

class WalletTest extends TestCase
{
    private Wallet $wallet;

    protected function setUp(): void
    {
        $this->wallet = new Wallet('EUR');
    }

    public function testInitialBalance(): void
    {
        $this->assertEquals(0, $this->wallet->getBalance());
    }

    public function testAddFund(): void
    {
        $this->wallet->addFund(100.0);
        $this->assertEquals(100.0, $this->wallet->getBalance());
    }

    public function testRemoveFund(): void
    {
        $this->wallet->addFund(100.0);
        $this->wallet->removeFund(50.0);
        $this->assertEquals(50.0, $this->wallet->getBalance());
    }

    public function testGetCurrency(): void
    {
        $this->assertEquals('EUR', $this->wallet->getCurrency());
    }

    public function testSetCurrency(): void
    {
        $this->wallet->setCurrency('USD');
        $this->assertEquals('USD', $this->wallet->getCurrency());
    }
}
