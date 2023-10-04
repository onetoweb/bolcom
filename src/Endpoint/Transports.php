<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Transports Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html#tag/Transports
 */
class Transports extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'transports';
    }
    
    /**
     * @param string $transportId
     * @param array $data
     * 
     * @return array
     */
    public function update(string $transportId, array $data): array
    {
        return $this->client->put($this->getUrl($transportId), $data);
    }
}