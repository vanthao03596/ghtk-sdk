<?php

namespace Vanthao03596\GhtkSdk\Tests;

use Vanthao03596\GhtkSdk\Exception\InvalidArgumentException;
use Vanthao03596\GhtkSdk\Exception\BadMethodCallException;
use PHPUnit\Framework\TestCase;
use Vanthao03596\GhtkSdk\Client;
use Psr\Http\Client\ClientInterface;
use Vanthao03596\GhtkSdk\HttpClient\Builder;
use Vanthao03596\GhtkSdk\HttpClient\Plugin\Authentication;
use Vanthao03596\GhtkSdk\Api;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function shouldNotHaveToPassHttpClientToConstructor()
    {
        $client = new Client();

        $this->assertInstanceOf(ClientInterface::class, $client->getHttpClient());
    }

    /**
     * @test
     */
    public function shouldPassHttpClientInterfaceToConstructor()
    {
        $httpClientMock = $this->getMockBuilder(ClientInterface::class)
            ->getMock();

        $client = Client::createWithHttpClient($httpClientMock);

        $this->assertInstanceOf(ClientInterface::class, $client->getHttpClient());
    }

    /**
     * @test
     */
    public function shouldAuthenticateUsingGivenParameters()
    {
        $builder = $this->getMockBuilder(Builder::class)
            ->onlyMethods(['addPlugin', 'removePlugin'])
            ->getMock();
        $builder->expects($this->once())
            ->method('addPlugin')
            ->with($this->equalTo(new Authentication('token')));

        $builder->expects($this->once())
            ->method('removePlugin')
            ->with(Authentication::class);

        $client = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getHttpClientBuilder'])
            ->getMock();
        $client->expects($this->any())
            ->method('getHttpClientBuilder')
            ->willReturn($builder);

        $client->authenticate('token');
    }

    /**
     * @test
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetApiInstance($apiName, $class)
    {
        $client = new Client();

        $this->assertInstanceOf($class, $client->api($apiName));
    }

    /**
     * @test
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetMagicApiInstance($apiName, $class)
    {
        $client = new Client();

        $this->assertInstanceOf($class, $client->$apiName());
    }

    /**
     * @test
     */
    public function shouldNotGetApiInstance()
    {
        $this->expectException(InvalidArgumentException::class);
        $client = new Client();
        $client->api('do_not_exist');
    }

    /**
     * @test
     */
    public function shouldNotGetMagicApiInstance()
    {
        $this->expectException(BadMethodCallException::class);
        $client = new Client();
        $client->doNotExist();
    }

    public function getApiClassesProvider()
    {
        return [
            ['shipment', Api\Shipment::class],
            ['address', Api\Address::class],
            ['inventory', Api\Inventory::class],
            ['order', Api\Order::class],
            ['shop', Api\Shop::class],
        ];
    }
}
