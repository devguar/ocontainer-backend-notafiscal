<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 08/02/2017
 * Time: 21:01
 */

namespace Devguar\OContainer\NotaFiscal\Services;


abstract class TinyService
{
    public $token;
    public $metodos_base_url = 'https://api.tiny.com.br/api2/';

    /**
     * TinyService constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    protected function enviarREST($url, $data, $optional_headers = null) {
        $params = array('http' => array(
            'method' => 'POST',
            'content' => $data
        ));

        if ($optional_headers !== null) {
            $params['http']['header'] = $optional_headers;
        }

        $php_errormsg = null;

        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if (!$fp) {
            throw new \Exception("Problema com $url, $php_errormsg");
        }
        $response = @stream_get_contents($fp);
        if ($response === false) {
            throw new \Exception("Problema obtendo retorno de $url, $php_errormsg");
        }

        $response = $this->serializarRetorno($response);

        return $response;
    }

    private function serializarRetorno($response){
        return json_decode($response);
    }
}