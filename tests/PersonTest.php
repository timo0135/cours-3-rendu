<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Person;
use App\Entity\Wallet;
use App\Entity\Product;

class PersonTest extends TestCase
{
    private Person $person;

    protected function setUp(): void
    {
        $this->person = new Person('Michel', 'EUR');
    }

    public function testGetName(): void
    {
        $this->assertEquals('Michel', $this->person->getName());
    }

    public function testHasFund(): void
    {
        $wallet = new Wallet('EUR');
        $this->person->setWallet($wallet);
        $this->assertTrue($this->person->hasFund());
    }

    public function testSetName(): void
    {
        $this->person->setName('Robert');
        $this->assertEquals('Robert', $this->person->getName());
    }

    public function testSetWallet(): void
    {
        $wallet = new Wallet('EUR');
        $this->person->setWallet($wallet);
        $this->assertSame($wallet, $this->person->getWallet());
    }


    public function testTransfertFund(): void
    {
        $wallet = new Wallet('EUR');
        $wallet->addFund(100.0);
        $this->person->setWallet($wallet);

        $recipient = new Person('Robert', 'EUR');
        $this->person->transfertFund(50.0, $recipient);

        $this->assertEquals(50.0, $this->person->getWallet()->getBalance());
        $this->assertEquals(50.0, $recipient->getWallet()->getBalance());
    }

    public function testTransfertFundExactBalance(): void
    {
        $wallet = new Wallet('EUR');
        $wallet->addFund(50.0);
        $this->person->setWallet($wallet);

        $recipient = new Person('Robert', 'EUR');
        $this->person->transfertFund(50.0, $recipient);

        $this->assertEquals(0.0, $this->person->getWallet()->getBalance());
        $this->assertEquals(50.0, $recipient->getWallet()->getBalance());
    }

    public static function fundProvider(): array
    {
        return [
            [100.0, 50.0, 50.0],
            [200.0, 100.0, 100.0],
            [50.0, 25.0, 25.0],
        ];
    }

    public function testBuyProduct(): void
    {
        $wallet = new Wallet('EUR');
        $wallet->addFund(100.0);
        $this->person->setWallet($wallet);

        $product = $this->createMock(Product::class);
        $product->method('listCurrencies')->willReturn(['EUR']);
        $product->method('getPrice')->with('EUR')->willReturn(50.0);

        $this->person->buyProduct($product);

        $this->assertEquals(50.0, $this->person->getWallet()->getBalance());
    }

}