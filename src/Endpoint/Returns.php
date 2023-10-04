<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Returns Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html#tag/Returns
 */
class Returns extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'returns';
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
     * @param array $data
     * 
     * @return array
     */
    public function create(array $data): array
    {
        return $this->client->post($this->getUrl(), $data);
    }
    
    /**
     * @param array $query
     * 
     * @return array
     */
    public function getById(string $returnId): array
    {
        return $this->client->get($this->getUrl($returnId));
    }
    
    /**
     * @param string $rmaId
     * @param array $data
     * 
     * @return array
     */
    public function handleByRmaId(string $rmaId, array $data): array
    {
        return $this->client->put($this->getUrl($rmaId), $data);
    }
}