<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Shipping Labels Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html#tag/Shipping-Labels
 */
class ShippingLabels extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'shipping-labels';
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
    public function getDeliveryOptions(array $data): array
    {
        return $this->client->post($this->getUrl('delivery-options'), $data);
    }
    
    /**
     * @param string $shippingLabelId
     * 
     * @return string
     */
    public function getById(string $shippingLabelId): string
    {
        $this->setAcceptType(Client::ACCEPT_TYPE_PDF);
        
        return $this->client->get($this->getUrl($shippingLabelId));
    }
}