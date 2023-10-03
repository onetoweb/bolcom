<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Insights Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html#tag/Insights
 */
class Insights extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'insights';
    }
    
    /**
     * @param array $query = []
     */
    public function getOfferInsights(array $query = [])
    {
        return $this->client->get($this->getUrl('offer'), $query);
    }
    
    /**
     * @param array $query = []
     */
    public function getPerformanceIndicators(array $query = [])
    {
        return $this->client->get($this->getUrl('performance/indicator'), $query);
    }
    
    /**
     * @param array $query = []
     */
    public function getSalesForecast(array $query = [])
    {
        return $this->client->get($this->getUrl('sales-forecast'), $query);
    }
    
    /**
     * @param array $query = []
     */
    public function getSearchTerms(array $query = [])
    {
        return $this->client->get($this->getUrl('search-terms'), $query);
    }
}