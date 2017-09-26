<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 08/02/2017
 * Time: 21:01
 */

namespace Devguar\OContainer\NotaFiscal\Services;


abstract class FocusNfeService
{
    private $server = "";
    private $token = "";

    public $return_http_code;
    public $return_body;

    public function __construct($ambienteProducao = false, $token)
    {
        if ($ambienteProducao){
            $this->server = "https://api.focusnfe.com.br/nfe2/";
        }else{
            $this->server = "http://homologacao.acrasnfe.acras.com.br/nfe2/";
        }

        $this->token = $token;
    }

    public function sendPOST($uriMetodo, $data = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->server.$uriMetodo."&token=".$this->token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        if ($data){
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $this->return_http_code = $http_code;
        $this->return_body = $http_code;

        //as três linhas abaixo imprimem as informações retornadas pela API, aqui o seu sistema deverá
        //interpretar e lidar com o retorno
        print($http_code . "\n");
        print($body . "\n\n");
        print("");

        curl_close($ch);
    }

    public function sendGET($uriMetodo){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->server.$uriMetodo."&token=".$this->token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array());
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $this->return_http_code = $http_code;
        $this->return_body = $http_code;

        //as três linhas abaixo imprimem as informações retornadas pela API, aqui o seu sistema deverá
        //interpretar e lidar com o retorno
        print($http_code."\n");
        print($body."\n\n");
        print("");

        curl_close($ch);
    }
}