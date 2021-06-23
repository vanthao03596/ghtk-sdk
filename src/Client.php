<?php

declare(strict_types=1);

namespace Vanthao03596\GhtkSdk;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Vanthao03596\GhtkSdk\Api\AbstractApi;
use Vanthao03596\GhtkSdk\Exception\BadMethodCallException;
use Vanthao03596\GhtkSdk\Exception\InvalidArgumentException;
use Vanthao03596\GhtkSdk\HttpClient\Builder;
use Vanthao03596\GhtkSdk\HttpClient\Plugin\Authentication;
use Vanthao03596\GhtkSdk\HttpClient\Plugin\History;

/**
 * PHP GHTK client.
 *
 * @method Api\Shipment                       calculateFee()
 * @method Api\Shipment                       listPickAddress()
 * @method Api\Address                        getAddressLevel4()
 * @method Api\Inventory                      getProductInfo()
 * @method Api\Order                          create()
 * @method Api\Order                          checkStatus()
 * @method Api\Order                          cancel()
 * @method Api\Order                          printLabel()
 * @method Api\Shop                           create()
 * @method Api\Shop                           getToken()
 *
 * @author Pham Thao <phamthao03596@gmail.com>
 *
 * Website: https://docs.giaohangtietkiem.vn/
 */
class Client
{
    /**
     * @var string
     */
    private $apiVersion;

    /**
     * @var Builder
     */
    private $httpClientBuilder;

    /**
     * @var History
     */
    private $responseHistory;

    /**
     * Instantiate a new GHTK client.
     *
     * @param Builder|null $httpClientBuilder
     * @param string|null $apiVersion
     * @param bool $testMode
     */
    public function __construct(Builder $httpClientBuilder = null, bool $liveMode, $apiVersion = null)
    {
        $this->responseHistory = new History();
        $this->httpClientBuilder = $builder = $httpClientBuilder ?? new Builder();
        $this->apiVersion = $apiVersion ?: '1.6.2';

        $builder->addPlugin(new Plugin\HistoryPlugin($this->responseHistory));
        $builder->addPlugin(new Plugin\AddHostPlugin(Psr17FactoryDiscovery::findUriFactory()->createUri($liveMode ? 'https://services.giaohangtietkiem.vn' : 'https://services.ghtklab.com')));
        $builder->addPlugin(new Plugin\HeaderDefaultsPlugin([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]));
    }

    /**
     * Create a Ghtk\Client using a HTTP client.
     *
     * @param ClientInterface $httpClient
     *
     * @return Client
     */
    public static function createWithHttpClient(ClientInterface $httpClient, bool $testMode): self
    {
        $builder = new Builder($httpClient);

        return new self($builder, $testMode);
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return AbstractApi
     */
    public function api($name): AbstractApi
    {
        switch ($name) {
            case 'shipment':
                $api = new Api\Shipment($this);

                break;
            case 'address':
                $api = new Api\Address($this);

                break;
            case 'inventory':
                $api = new Api\Inventory($this);

                break;

            case 'order':
                $api = new Api\Order($this);

                break;

            case 'shop':
                $api = new Api\Shop($this);

                break;
            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }

        return $api;
    }

    /**
     * Authenticate a user for all next requests.
     *
     * @param string      $token GitHub private token
     *
     * @throws InvalidArgumentException If no token
     *
     * @return void
     */
    public function authenticate(string $token): void
    {
        if (empty($token)) {
            throw new InvalidArgumentException('You need token to authenticate!');
        }

        $this->getHttpClientBuilder()->removePlugin(Authentication::class);
        $this->getHttpClientBuilder()->addPlugin(new Authentication($token));
    }

    /**
     * @return string
     */
    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    /**
     * Add a cache plugin to cache responses locally.
     *
     * @param CacheItemPoolInterface $cachePool
     * @param array                  $config
     *
     * @return void
     */
    public function addCache(CacheItemPoolInterface $cachePool, array $config = []): void
    {
        $this->getHttpClientBuilder()->addCache($cachePool, $config);
    }

    /**
     * Remove the cache plugin.
     *
     * @return void
     */
    public function removeCache(): void
    {
        $this->getHttpClientBuilder()->removeCache();
    }

    /**
     * @param string $name
     * @param array  $args
     *
     * @return AbstractApi
     */
    public function __call($name, $args): AbstractApi
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name));
        }
    }

    /**
     * @return null|\Psr\Http\Message\ResponseInterface
     */
    public function getLastResponse(): ?ResponseInterface
    {
        return $this->responseHistory->getLastResponse();
    }

    /**
     * @return HttpMethodsClientInterface
     */
    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->getHttpClientBuilder()->getHttpClient();
    }

    /**
     * @return Builder
     */
    protected function getHttpClientBuilder(): Builder
    {
        return $this->httpClientBuilder;
    }
}
