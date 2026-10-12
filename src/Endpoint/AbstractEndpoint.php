<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;
use Onetoweb\Bolcom\Config\{AcceptType, Url};

/**
 * Abstract Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 */
abstract class AbstractEndpoint implements EndpointInterface
{
    /**
     * @param Client $client
     */
    public function __construct(
        protected Client $client
    ) {
        
    }
    
    /**
     * @param AcceptType $acceptType = AcceptType::JSON
     * 
     * @return void
     */
    protected function setAcceptType(AcceptType $acceptType = AcceptType::JSON): void
    {
        $this->client->setAcceptType($acceptType);
    }
    
    /**
     * @param string|null $endpoint = null
     * 
     * @return string
     */
    protected function getUrl(?string $endpoint = null): string
    {
        return rtrim(implode('/', [
            Url::BASE->value,
            $this->client->isDemo() ? 'retailer-demo' : 'retailer',
            $this->getName(),
            $endpoint
        ]), '/');
    }
    
    /**
     * @param string|null  $endpoint = null
     * 
     * @return string
     */
    protected function getUrlShared(?string $endpoint = null): string
    {
        return rtrim(implode('/', [
            Url::BASE->value,
            $this->client->isDemo() ? 'shared-demo' : 'shared',
            $this->getName(),
            $endpoint
        ]), '/');
    }
}
