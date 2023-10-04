<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Shipments Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html#tag/Shipments
 */
class Shipments extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'shipments';
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
    public function getInvoicesRequests(array $query): array
    {
        return $this->client->get($this->getUrl('invoices/requests'), $query);
    }
    
    /**
     * @param string $shipmentId
     * 
     * @return array
     */
    public function getById(string $shipmentId): array
    {
        return $this->client->get($this->getUrl($shipmentId));
    }
}