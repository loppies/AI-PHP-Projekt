<?php

namespace Clocker\Controllers;

class ClockerResponse {
    public string $redirect;
    public int $statusCode;
    public array $message = [];
    public array $value = [];

    public function __construct($redirect = "", $statusCode = 0, $message = [], $value = [])
    {
        $this->redirect = $redirect;
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->value = $value;
    }
}