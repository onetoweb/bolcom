<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Replenishments Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html#tag/Replenishments
 */
class Replenishments extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'replenishments';
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
     * @return array
     */
    public function getDeliveryDates(): array
    {
        return $this->client->get($this->getUrl('delivery-dates'));
    }
    
    /**
     * @param array $data
     * 
     * @return array
     */
    public function createPickupTimeSlots(array $data): array
    {
        return $this->client->post($this->getUrl('pickup-time-slots'), $data);
    }
    
    /**
     * @param array $data
     *
     * @return array
     */
    public function getProductDestinations(array $data): array
    {
        return $this->client->post($this->getUrl('product-destinations'), $data);
    }
    
    /**
     * @param string $productDestinationsId
     * 
     * @return array
     */
    public function getProductDestinationsByDestinationsId(string $productDestinationsId): array
    {
        return $this->client->get($this->getUrl("product-destinations/{$productDestinationsId}"));
    }
    
    /**
     * @param array $data
     * 
     * @return array
     */
    public function createProductLabels(array $data): string
    {
        $this->setAcceptType(Client::ACCEPT_TYPE_PDF);
        
        return $this->client->post($this->getUrl('product-labels'), $data);
    }
    
    /**
     * @param string $replenishmentId
     * 
     * @return array
     */
    public function getById(string $replenishmentId): array
    {
        return $this->client->get($this->getUrl($replenishmentId));
    }
    
    /**
     * @param string $replenishmentId
     * @param array $data
     * 
     * @return array
     */
    public function update(string $replenishmentId, array $data): array
    {
        return $this->client->put($this->getUrl($replenishmentId), $data);
    }
    
    /**
     * @param string $replenishmentId
     * @param array $query = []
     * 
     * @return array
     */
    public function getLoadCarrierLabelsById(string $replenishmentId, array $query = []): string
    {
        $this->setAcceptType(Client::ACCEPT_TYPE_PDF);
        
        return $this->client->get($this->getUrl("$replenishmentId/load-carrier-labels"), $query);
    }
    
    /**
     * @param string $replenishmentId
     *
     * @return array
     */
    public function getPickListById(string $replenishmentId): string
    {
        $this->setAcceptType(Client::ACCEPT_TYPE_PDF);
        
        return $this->client->get($this->getUrl("$replenishmentId/pick-list"));
    }
}