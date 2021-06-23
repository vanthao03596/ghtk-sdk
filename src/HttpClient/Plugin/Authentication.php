<?php

declare(strict_types=1);

namespace Vanthao03596\GhtkSdk\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;

final class Authentication implements Plugin
{
    /**
     * The authorization token.
     *
     * @var string
     */
    private $token;

    /**
     * Create a new authentication plugin instance.
     *
     * @param string      $token
     * @return void
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return Promise
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $request = $request->withHeader('Token', $this->token);

        return $next($request);
    }

}
