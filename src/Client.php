<?php

namespace Onetoweb\Bolcom;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Onetoweb\Bolcom\{Token, Endpoint};
use DateTime;

/**
 * Client.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 * 
 * @see https://api.bol.com/retailer/public/redoc/v10/retailer.html
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
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_DELETE = 'DELETE';
    public const METHOD_OPTIONS = 'OPTIONS';
    public const METHOD_HEAD = 'HEAD';
    
    /**
     * Version
     */
    public const VERSION = 10;
    
    /**
     * Accept Types
     */
    public const ACCEPT_TYPE_JSON = 'json';
    public const ACCEPT_TYPE_CSV = 'csv';
    public const ACCEPT_TYPE_PDF = 'pdf';
    
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
     * @var bool
     */
    private $demo;
    
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
     * @var string
     */
    private $acceptType = self::ACCEPT_TYPE_JSON;
    
    /**
     * @param string $clientId
     * @param string $secret
     * @param int $version = self::VERSION
     * @param bool $demo = false
     */
    public function __construct(string $clientId, string $secret, int $version = self::VERSION, bool $demo = false)
    {
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->version = $version;
        $this->demo = $demo;
        
        // load endpoints
        $this->loadEndpoints();
    }
    
    /**
     * @return string[]
     */
    public static function getMethods(): array
    {
        return [
            self::METHOD_GET,
            self::METHOD_POST,
            self::METHOD_PUT,
            self::METHOD_PATCH,
            self::METHOD_DELETE,
            self::METHOD_OPTIONS,
            self::METHOD_HEAD
        ];
    }
    
    /**
     * @return bool
     */
    public function isDemo(): bool
    {
        return $this->demo;
    }
    
    /**
     * @return void
     */
    private function loadEndpoints(): void
    {
        $this->commission = new Endpoint\Commission($this);
        $this->insights = new Endpoint\Insights($this);
        $this->inventory = new Endpoint\Inventory($this);
        $this->invoices = new Endpoint\Invoices($this);
        $this->offers = new Endpoint\Offers($this);
        $this->orders = new Endpoint\Orders($this);
        $this->productContent = new Endpoint\ProductContent($this);
        $this->products = new Endpoint\Products($this);
        $this->promotions = new Endpoint\Promotions($this);
        $this->replenishments = new Endpoint\Replenishments($this);
        $this->retailers = new Endpoint\Retailers($this);
        $this->returns = new Endpoint\Returns($this);
        $this->shipments = new Endpoint\Shipments($this);
        $this->shippingLabels = new Endpoint\ShippingLabels($this);
        $this->subscriptions = new Endpoint\Subscriptions($this);
        $this->transports = new Endpoint\Transports($this);
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
     * @param array $data = []
     * @param array $query = []
     * 
     * @return mixed
     */
    public function patch(string $endpoint, array $data = [], array $query = [])
    {
        return $this->request(self::METHOD_PATCH, $endpoint, $data, $query);
    }
    
    /**
     * @param string $endpoint
     * @param array $query = []
     * 
     * @return mixed
     */
    public function delete(string $endpoint, array $query = [])
    {
        return $this->request(self::METHOD_DELETE, $endpoint, [], $query);
    }
    
    /**
     * @param string $endpoint
     * @param array $query = []
     * 
     * @return mixed
     */
    public function options(string $endpoint, array $query = [])
    {
        return $this->request(self::METHOD_OPTIONS, $endpoint, [], $query);
    }
    
    /**
     * @param string $endpoint
     * 
     * @return mixed
     */
    public function head(string $endpoint)
    {
        return $this->request(self::METHOD_HEAD, $endpoint);
    }
    
    /**
     * @param string $acceptType = Client::ACCEPT_TYPE_JSON
     *
     * @return void
     */
    public function setAcceptType(string $acceptType = Client::ACCEPT_TYPE_JSON): void
    {
        $this->acceptType = $acceptType;
    }
    
    /**
     * @param string $method
     * @param string $endpoint
     * @param array $data = []
     * @param array $query = []
     * @param string $requester
     * 
     * @return mixed
     */
    public function request(string $method, string $endpoint, array $data = [], array $query = [])
    {
        // get access token
        if ($this->token === null or $this->token->isExpired()) {
            $this->getAccessToken();
        }
        
        // build options
        $options = [
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::HEADERS => [
                'Accept' => "application/vnd.retailer.v{$this->version}+{$this->acceptType}",
                'Content-Type' => "application/vnd.retailer.v{$this->version}+json",
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
        
        if ($this->acceptType == Client::ACCEPT_TYPE_JSON) {
            
            // return array
            return json_decode($contents, true);
            
        } else {
            
            // reset accept type to json
            $this->acceptType = self::ACCEPT_TYPE_JSON;
            
            // return contents
            return $contents;
        }
    }
}