<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Product Content Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html#tag/Product-Content
 */
class ProductContent extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'content';
    }
    
    /**
     * @param string $ean
     * 
     * @return array
     */
    public function getByEan(string $ean): array
    {
        return $this->client->get($this->getUrl("catalog-products/$ean"));
    }
    
    /**
     * @param array $data
     * 
     * @return array
     */
    public function getChunkRecommendations(array $data): array
    {
        return $this->client->post($this->getUrl('chunk-recommendations'), $data);
    }
    
    /**
     * @param array $data
     *
     * @return array
     */
    public function create(array $data): array
    {
        return $this->client->post($this->getUrl('products'), $data);
    }
    
    /**
     * @param string $uploadId
     * 
     * @return array
     */
    public function getUploadReport(string $uploadId): array
    {
        return $this->client->get($this->getUrl("upload-report/$uploadId"));
    }
}