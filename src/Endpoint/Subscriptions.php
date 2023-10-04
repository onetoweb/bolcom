<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Subscriptions Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html#tag/Subscriptions
 */
class Subscriptions extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'subscriptions';
    }
    
    /**
     * @return array
     */
    public function get(): array
    {
        return $this->client->get($this->getUrl());
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
    public function getSignatureKeys(): array
    {
        return $this->client->get($this->getUrl('signature-keys'));
    }
    
    /**
     * @param string $subscriptionId
     * 
     * @return array
     */
    public function test(string $subscriptionId): array
    {
        return $this->client->post($this->getUrl("test/$subscriptionId"));
    }
    
    /**
     * @param string $subscriptionId
     *
     * @return array
     */
    public function getById(string $subscriptionId): array
    {
        return $this->client->get($this->getUrl($subscriptionId));
    }
    
    /**
     * @param string $subscriptionId
     * @param array $data
     * 
     * @return array
     */
    public function update(string $subscriptionId, array $data): array
    {
        return $this->client->put($this->getUrl($subscriptionId), $data);
    }
    
    /**
     * @param string $subscriptionId
     * @param array $data
     *
     * @return array
     */
    public function delete(string $subscriptionId): array
    {
        return $this->client->delete($this->getUrl($subscriptionId));
    }
}