<?php

namespace Onetoweb\Bolcom;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\{ClientException, RequestException  as GuzzleRequestException};
use Onetoweb\Bolcom\Exception\{RequestException, RequestJsonException};
use Onetoweb\Bolcom\Token;
use DateTime;

/**
 * Client.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v5
 */
class Client
{
    /**
     * Base uri
     */
    public const BASE_URI = 'https://api.bol.com';
    
    /**
     * Methods
     */
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';
    
    /**
     * Version
     */
    public const VERSION = 9;
    
    /**
     * @var string
     */
    private $clientId;
    
    /**
     * @var string
     */
    private $secret;
    
    /**
     * @var Token
     */
    private $token;
    
    /**
     * @var int
     */
    private $version;
    
    /**
     * @var array
     */
    private $rateLimits;
    
    /**
     * @var callable
     */
    private $limitReachedCallback;
    
    /**
     * @var int
     */
    private $rateLimit;
    
    /**
     * @var int
     */
    private $rateLimitRemaining;
    
    /**
     * @var int
     */
    private $rateLimitReset;
    
    /**
     * @param string $clientId
     * @param string $secret
     * @param int $version = self::VERSION
     */
    public function __construct(string $clientId, string $secret, int $version = self::VERSION)
    {
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->version = $version;
    }
    
    /**
     * @return void
     */
    private function getAccessToken(): void
    {
        $options = [
            RequestOptions::HEADERS => [
                'Authorization' => 'Basic ' . base64_encode("{$this->clientId}:{$this->secret}")
            ]
        ];
        
        $client = new GuzzleClient();
        $response = $client->request(self::METHOD_POST, 'https://login.bol.com/token?grant_type=client_credentials', $options);
        
        $accessToken = json_decode($response->getBody()->getContents());
       
        $expires = (new DateTime())->setTimestamp(time() - $accessToken->expires_in);
        
        $token = new Token($accessToken->access_token, $expires);
        
        $this->token = $token;
    }
    
    /**
     * @var int|null
     */
    public function getRateLimit(): ?int
    {
        return $this->rateLimit;
    }
    
    /**
     * @var int|null
     */
    public function getRateLimitRemaining(): ?int
    {
        return $this->rateLimitRemaining;
    }
    
    /**
     * @var int|null
     */
    public function getRateLimitReset(): ?int
    {
        return $this->rateLimitReset;
    }
    
    /**
     * @return array
     */
    public function getRateLimits():  array
    {
        if ($this->rateLimits == null) {
            
            $client = new GuzzleClient();
            $response = $client->request(self::METHOD_GET, self::BASE_URI.'/retailer/public/ratelimits');
            
            $this->rateLimits = json_decode($response->getBody()->getContents(), true);
        }
        
        return $this->rateLimits;
    }
    
    /**
     * @param callable $limitReachedCallback
     */
    public function setLimitReachedCallback(callable $limitReachedCallback): void
    {
        $this->limitReachedCallback = $limitReachedCallback;
    }
    
    /**
     * @param string $endpoint
     * @param array $query = []
     *
     * @return mixed
     */
    public function get(string $endpoint, array $query = [])
    {
        return $this->request(self::METHOD_GET, $endpoint, [], $query);
    }
    
    /**
     * @param string $endpoint
     * @param array $data = []
     * @param array $query = []
     *
     * @return mixed
     */
    public function post(string $endpoint, array $data = [], array $query = [])
    {
        return $this->request(self::METHOD_POST, $endpoint, $data, $query);
    }
    
    /**
     * @param string $endpoint
     * @param array $data = []
     * @param array $query = []
     *
     * @return mixed
     */
    public function put(string $endpoint, array $data = [], array $query = [])
    {
        return $this->request(self::METHOD_PUT, $endpoint, $data, $query);
    }
    
    /**
     * @param string $endpoint
     * @param array $query = []
     *
     * @return mixed
     */
    public function delete(string $endpoint, array $query = [])
    {
        return $this->request(self::METHOD_DELETE, $endpoint, $query);
    }
    
    /**
     * @param string $method
     * @param string $endpoint
     * @param array $data = []
     * @param array $query = []
     * 
     * @throws RequestException
     * @throws RequestJsonException if a request contains validation errors
     * 
     * @return mixed
     */
    public function request(string $method, string $endpoint, array $data = [], array $query = [])
    {
        // get access token
        if ($this->token === null or $this->token->isExpired()) {
            $this->getAccessToken();
        }
        
        // get accept type
        if (
            $endpoint == '/retailer/replenishments/product-labels'
            or fnmatch('/retailer/replenishments/*/load-carrier-labels', $endpoint)
            or fnmatch('/retailer/replenishments/*/pick-list', $endpoint)
            or fnmatch('/retailer/shipping-labels/*', $endpoint)
        ) {
            $acceptType = 'pdf';
        } else if (fnmatch('/retailer/offers/export/*', $endpoint)) {
            $acceptType = 'csv';
        } else {
            $acceptType = 'json';
        }
        
        // get mime type
        $mimeType = "application/vnd.retailer.v{$this->version}+";
        
        // build options
        $options = [
            RequestOptions::HEADERS => [
                'Accept' => $mimeType.$acceptType,
                'Content-Type' => $mimeType.'json',
                'Authorization' => "Bearer {$this->token->getValue()}"
            ]
        ];
        
        // add query
        if (count($query) > 0) {
            $options[RequestOptions::QUERY] = $query;
        }
        
        // add data
        if (count($data) > 0) {
            $options[RequestOptions::JSON] = $data;
        }
        
        // get guzzle client
        $client = new GuzzleClient([
            'base_uri' => self::BASE_URI,
        ]);
        
        try {
            
            // request
            $response = $client->request($method, $endpoint, $options);
            
            // get ratelimit
            $this->rateLimit = (int) $response->getHeaderLine('X-RateLimit-Limit');
            $this->rateLimitRemaining = (int) $response->getHeaderLine('X-RateLimit-Remaining');
            $this->rateLimitReset = (int) $response->getHeaderLine('X-RateLimit-Reset');
            
            if ($this->limitReachedCallback !== null) {
                
                // check rate limit
                if ($this->rateLimitRemaining == 0) {
                    
                    ($this->limitReachedCallback)($this->rateLimitReset);
                }
            }
            
            // get contents
            $contents = $response->getBody()->getContents();
            
            // return contents
            if ($acceptType !== 'json') {
                
                // return string
                return $contents;
                
            } else {
                
                // return array
                return json_decode($contents, true);
            }
            
        } catch (ClientException|GuzzleRequestException $exception) {
            
            if ($exception->hasResponse() and $exception->getResponse()->getBody()->getSize() > 0) {
                throw new RequestJsonException($exception->getResponse()->getBody()->getContents(), $exception->getCode(), $exception);
            }
            
            throw new RequestException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}