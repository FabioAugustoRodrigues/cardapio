<?php

namespace app\controller\http;

use app\helper\http\PayloadHttp;

require_once '../../../vendor/autoload.php';

abstract class ControllerAbstract
{
    public function __construct() {}

    protected function respondeComDados($dados = null, int $status = 200)
    {
        $payload = new PayloadHttp($status, $dados);
        return $this->responde($payload);
    }

    protected function responde(PayloadHttp $payload)
    {
        $json = json_encode($payload);
        $json = $this->formatJson($json);

        http_response_code($payload->getStatus());

        return $json;
    }

    protected function formatJson(string $json)
    {
        $json = preg_replace('/,/', '$0 ', $json);

        return $json;
    }

}
