<?php

namespace Clocker\Controllers;

class Response
{
    public $statusCode;
    public $message;
    public $value;

    public function __construct($statusCode, $message, $value)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->value = $value;
    }
}