<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Promotions Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html#tag/Promotions
 */
class Promotions extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'promotions';
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
     * @param string $promotionId
     * 
     * @return array
     */
    public function getById(string $promotionId): array
    {
        return $this->client->get($this->getUrl($promotionId));
    }
    
    /**
     * @param string $promotionId
     * @param array $query = []
     * 
     * @return array
     */
    public function getProductsById(string $promotionId, array $query = []): array
    {
        return $this->client->get($this->getUrl("$promotionId/products"), $query);
    }
}