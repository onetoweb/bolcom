<?php

namespace Onetoweb\Bolcom\Exception;

use Exception;

/**
 * Request Exception.
 * 
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 */
class RequestJsonException extends Exception
{
    /**
     * @return array
     */
    public function getMessageArray(): array
    {
        return json_decode($this->getMessage(), true);
    }
}