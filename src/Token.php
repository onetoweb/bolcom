<?php

namespace Onetoweb\Bolcom;

use DateTime;

/**
 * Token.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 */
class Token
{
    /**
     * @param string $value
     * @param DateTime $expires
     */
    public function __construct(
        private string $value,
        private DateTime $expires
    ) {
        
    }
    
    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
    
    /**
     * @return DateTime
     */
    public function getExpires(): DateTime
    {
        return $this->expires;
    }
    
    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return ($this->expires < new DateTime());
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
