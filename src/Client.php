<?php

namespace Onetoweb\Bolcom;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Onetoweb\Bolcom\{Token, Endpoint};
use Onetoweb\Bolcom\Config\{Method, AcceptType, Url};
use DateTime;
use Closure;

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
     * Version
     */
    public const VERSION = 11;
    
    /**
     * @var Token
     */
    private ?Token $token = null;
    
    /**
     * @var array
     */
    private ?array $rateLimits = null;
    
    /**
     * @var Closure
     */
    private ?Closure $limitReachedCallback = null;
    
    /**
     * @var int
     */
    private ?int $rateLimit = null;
    
    /**
     * @var int
     */
    private ?int $rateLimitRemaining = null;
    
    /**
     * @var int
     */
    private ?int $rateLimitReset = null;
    
    /**
     * @var AcceptType
     */
    private AcceptType $acceptType = AcceptType::JSON;
    
    /**
     * @param string $clientId
     * @param string $secret
     * @param int $version = self::VERSION
     * @param bool $demo = false
     */
    public function __construct(
        
        #[\SensitiveParameter]
        private string $clientId,
        
        #[\SensitiveParameter]
        private string $secret,
        
        private int $version = self::VERSION,
        private bool $demo = false
    ) {
        // load endpoints
        $this->loadEndpoints();
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
        $this->processStatus = new Endpoint\ProcessStatus($this);
    }
    
    /**
     * @return void
     */
    private function getAccessToken(): void
    {
        $options = [
            RequestOptions::HEADERS => [
                'Authorization' => 'Basic ' . base64_encode("{$this->clientId}:{$this->secret}")
            ],
            RequestOptions::QUERY => [
                'grant_type' => 'client_credentials'
            ]
        ];
        
        $client = new GuzzleClient();
        $response = $client->request(Method::POST->value, Url::LOGIN->value, $options);
        
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
            $response = $client->request(Method::GET->value, Url::BASE->value.'/retailer/public/ratelimits');
            
            $this->rateLimits = json_decode($response->getBody()->getContents(), true);
        }
        
        return $this->rateLimits;
    }
    
    /**
     * @param Closure $limitReachedCallback
     */
    public function setLimitReachedCallback(Closure $limitReachedCallback): void
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
        return $this->request(Method::GET, $endpoint, [], $query);
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
        return $this->request(Method::POST, $endpoint, $data, $query);
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
        return $this->request(Method::PUT, $endpoint, $data, $query);
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
        return $this->request(Method::PATCH, $endpoint, $data, $query);
    }
    
    /**
     * @param string $endpoint
     * @param array $query = []
     * 
     * @return mixed
     */
    public function delete(string $endpoint, array $query = [])
    {
        return $this->request(Method::DELETE, $endpoint, [], $query);
    }
    
    /**
     * @param string $endpoint
     * @param array $query = []
     * 
     * @return mixed
     */
    public function options(string $endpoint, array $query = [])
    {
        return $this->request(Method::OPTIONS, $endpoint, [], $query);
    }
    
    /**
     * @param string $endpoint
     * 
     * @return mixed
     */
    public function head(string $endpoint)
    {
        return $this->request(Method::HEAD, $endpoint);
    }
    
    /**
     * @param AcceptType $acceptType = AcceptType::JSON
     *
     * @return void
     */
    public function setAcceptType(AcceptType $acceptType = AcceptType::JSON): void
    {
        $this->acceptType = $acceptType;
    }
    
    /**
     * @param Method $method
     * @param string $endpoint
     * @param array $data = []
     * @param array $query = []
     * @param string $requester
     * 
     * @return mixed
     */
    public function request(Method $method, string $endpoint, array $data = [], array $query = [])
    {
        // get access token
        if ($this->token === null or $this->token->isExpired()) {
            $this->getAccessToken();
        }
        
        // build options
        $options = [
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::HEADERS => [
                'Accept' => "application/vnd.retailer.v{$this->version}+{$this->acceptType->value}",
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
            'base_uri' => Url::BASE->value,
        ]);
        
        // request
        $response = $client->request($method->value, $endpoint, $options);
        
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
        
        if (
            $this->acceptType == AcceptType::JSON
            or !in_array($response->getStatusCode(), range(200, 299))
        ) {
            
            // return array
            return json_decode($contents, true);
            
        } else {
            
            // reset accept type to json
            $this->acceptType = AcceptType::JSON;
            
            // return contents
            return $contents;
        }
    }
}
