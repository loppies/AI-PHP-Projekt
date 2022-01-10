<?php

namespace Clocker\Controllers;

use ErrorException;
use http\Exception;

class ErrorBuilder {
    /**
     * @throws ErrorException
     */
    static function buildUrlQuery ($message, $type) {
        if (strlen($message) == 0 || strlen($type) == 0) {
            throw new ErrorException("Błędnie zbudowany URL z informacją o błędzie.");
        }

        $errorStr = "?"
            . "message="
            . urlencode($message)
            . "&"
            . "type="
            . urlencode($type);

        return $errorStr;
    }
}