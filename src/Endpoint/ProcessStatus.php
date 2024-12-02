<?php

namespace Onetoweb\Bolcom\Endpoint;

use Onetoweb\Bolcom\Client;

/**
 * Process Status Endpoint.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/shared.html#tag/Process-Status
 */
class ProcessStatus extends AbstractEndpoint
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'process-status';
    }
    
    /**
     * @param array $query
     * 
     * @return array
     */
    public function get(array $query): ?array
    {
        return $this->client->get($this->getUrlShared(), $query);
    }
    
    /**
     * @param array $data
     *
     * @return array
     */
    public function getMultiple(array $processStatusIds): ?array
    {
        $processStatusQueries = [];
        foreach ($processStatusIds as $processStatusId) {
            $processStatusQueries[] = [
                'processStatusId' => $processStatusId
            ];
        }
        
        return $this->client->post($this->getUrlShared(), [
            'processStatusQueries' => $processStatusQueries
        ]);
    }
    
    /**
     * @param string $id
     * 
     * @return array
     */
    public function getById(string $id): ?array
    {
        return $this->client->get($this->getUrlShared($id));
    }
}
