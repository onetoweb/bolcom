<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Retailers Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html#tag/Retailers
 */
class Retailers extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'retailers';
    }
    
    /**
     * @param string $retailerId
     * 
     * @return array
     */
    public function getById(string $retailerId): array
    {
        return $this->client->get($this->getUrl($retailerId));
    }
}