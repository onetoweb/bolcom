<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Abstract Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 */
abstract class AbstractEndpoint implements EndpointInterface
{
    /**
     * @var Client
     */
    protected $client;
    
    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    /**
     * @param string $acceptType = Client::ACCEPT_TYPE_JSON
     * 
     * @return void
     */
    protected function setAcceptType(string $acceptType = Client::ACCEPT_TYPE_JSON): void
    {
        $this->client->setAcceptType($acceptType);
    }
    
    /**
     * @param string $endpoint = null
     * 
     * @return string
     */
    protected function getUrl(string $endpoint = null): string
    {
        return implode('/', [
            $this->client::BASE_URI,
            $this->client->isDemo() ? 'retailer-demo' : 'retailer',
            $this->getName(),
            $endpoint
        ]);
    }
}