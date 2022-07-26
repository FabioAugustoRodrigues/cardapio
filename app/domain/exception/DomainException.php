<?php

namespace app\domain\exception;

use Exception;

require_once "../../../vendor/autoload.php";

class DomainException extends Exception{

    public function __construct($mensagem) {
        parent::__construct($mensagem, 0, null);
    }

}