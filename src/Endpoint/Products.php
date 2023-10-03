<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Products Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html#tag/Products
 */
class Products extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'products';
    }
    
    /**
     * @param array $data
     * 
     * @return array
     */
    public function get(array $data): array
    {
        return $this->client->post($this->getUrl('list'), $data);
    }
    
    /**
     * @param array $query
     * 
     * @return array
     */
    public function getListFilters(array $query): array
    {
        return $this->client->get($this->getUrl('list-filters'), $query);
    }
    
    /**
     * @param string $ean
     * @param array $query = []
     * 
     * @return array
     */
    public function getAssetsByEan(string $ean, array $query = []): array
    {
        return $this->client->get($this->getUrl("$ean/assets"), $query);
    }
    
    /**
     * @param string $ean
     * @param array $query = []
     * 
     * @return array
     */
    public function getCompetingOffersByEan(string $ean, array $query = []): array
    {
        return $this->client->get($this->getUrl("$ean/offers"), $query);
    }
    
    /**
     * @param string $ean
     * @param array $query = []
     *
     * @return array
     */
    public function getPlacementByEan(string $ean, array $query = []): array
    {
        return $this->client->get($this->getUrl("$ean/placement"), $query);
    }
    
    /**
     * @param string $ean
     * 
     * @return array
     */
    public function getPriceStarBoundariesByEan(string $ean): array
    {
        return $this->client->get($this->getUrl("$ean/price-star-boundaries"));
    }
    
    /**
     * @param string $ean
     * 
     * @return array
     */
    public function getIdsByEan(string $ean): array
    {
        return $this->client->get($this->getUrl("$ean/product-ids"));
    }
    
    /**
     * @param string $ean
     * 
     * @return array
     */
    public function getRatingsByEan(string $ean): array
    {
        return $this->client->get($this->getUrl("$ean/ratings"));
    }
}