<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Orders Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html#tag/Orders
 */
class Orders extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'orders';
    }
    
    /**
     * @param array $query
     * 
     * @return array
     */
    public function get(array $query): array
    {
        return $this->client->get($this->getUrl(), $query);
    }
    
    /**
     * @param array $query
     * 
     * @return array
     */
    public function cancelOrderItem(array $query): array
    {
        return $this->client->put($this->getUrl('cancellation'), $query);
    }
    
    /**
     * @param string $orderId
     * 
     * @return array
     */
    public function getById(string $orderId): array
    {
        return $this->client->get($this->getUrl($orderId));
    }
}