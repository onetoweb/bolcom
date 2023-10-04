<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Offers Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html#tag/Offers
 */
class Offers extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'offers';
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
     * @param array $data
     * 
     * @return array
     */
    public function export(array $data): array
    {
        return $this->client->post($this->getUrl('export'), $data);
    }
    
    /**
     * @param string $reportId
     * 
     * @return string
     */
    public function exportByReportId(string $reportId)
    {
        $this->setAcceptType(Client::ACCEPT_TYPE_CSV);
        
        return $this->client->get($this->getUrl("export/$reportId"));
    }
    
    /**
     * @param array $data
     * 
     * @return array
     */
    public function getUnpublished(array $data): array
    {
        return $this->client->post($this->getUrl('unpublished'), $data);
    }
    
    /**
     * @param string $offerId
     * 
     * @return array|string
     */
    public function getUnpublishedById(string $offerId)
    {
        $this->setAcceptType(Client::ACCEPT_TYPE_CSV);
        
        return $this->client->get($this->getUrl("unpublished/$offerId"));
    }
    
    /**
     * @param string $offerId
     * 
     * @return array
     */
    public function getById(string $offerId): array
    {
        return $this->client->get($this->getUrl($offerId));
    }
    
    /**
     * @param string $offerId
     * 
     * @return array|string
     */
    public function update(string $offerId, array $data): array
    {
        return $this->client->put($this->getUrl($offerId), $data);
    }
    
    /**
     * @param string $offerId
     * 
     * @return array
     */
    public function delete(string $offerId): array
    {
        return $this->client->delete($this->getUrl($offerId));
    }
    
    /**
     * @param string $offerId
     * 
     * @return array
     */
    public function updatePrice(string $offerId, array $data): array
    {
        return $this->client->put($this->getUrl("$offerId/price"), $data);
    }
    
    /**
     * @param string $offerId
     * 
     * @return array
     */
    public function updateStock(string $offerId, array $data): array
    {
        return $this->client->put($this->getUrl("$offerId/stock"), $data);
    }
}