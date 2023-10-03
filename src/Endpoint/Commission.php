<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Commission Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html#tag/Commissions
 */
class Commission extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'commission';
    }
    
    /**
     * @param array $data = []
     */
    public function getCommissionBulk(array $data = [])
    {
        return $this->client->post($this->getUrl('commission'), $data);
    }
    
    /**
     * @param string $ean
     * @param array $query = []
     */
    public function getCommission(string $ean, array $query = [])
    {
        return $this->client->get($this->getUrl("commission/$ean"), $query);
    }
}