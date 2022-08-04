<?php

namespace app\domain\exception\http;

require_once "../../../vendor/autoload.php";

class ValidacaoHttpException extends DomainHttpException{

    public function __construct($mensagem, int $status = 400) {
        parent::__construct($mensagem, $status);
    }

}