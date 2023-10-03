<?php

namespace Onetoweb\Bolcom\Endpoint;

/**
 * Inventory Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html#tag/Invoices
 */
class Invoices extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'invoices';
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
     * @param string $invoiceId
     * 
     * @return array
     */
    public function getById(string $invoiceId): array
    {
        return $this->client->get($this->getUrl($invoiceId));
    }
    
    /**
     * @param string $invoiceId
     *
     * @return array
     */
    public function getSpecificationById(string $invoiceId): array
    {
        return $this->client->get($this->getUrl("$invoiceId/specification"));
    }
}