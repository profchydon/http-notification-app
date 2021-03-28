<?php

namespace App\Exceptions;

use Exception;

class PublishMessageException extends Exception
{
    protected $reason;

    public function setReason(string $reason)
    {
        $this->reason = $reason;
    }

    public function getReason()
    {
        return $this->reason;
    }
    
}
