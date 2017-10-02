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
    const AMBIENTE_PRODUCAO = 'P';
    const AMBIENTE_HOMOLOGACAO = 'H';
    const STATUS_AGUARDANDO_AUTORIZACAO = 'processando_autorizacao';

    private $ambiente;
    private $server = "";
    private $token = "";

    public $return_http_code;
    public $return_body;
    public $erros;
    public $retorno;

    protected abstract function urlServerHomologacao();
    protected abstract function urlServerProducao();

    public function __construct($ambiente, $token)
    {
        if ($ambiente == self::AMBIENTE_PRODUCAO){
            $this->server = $this->urlServerProducao();
        }else{
            $this->server = $this->urlServerHomologacao();
        }

        $this->ambiente = $ambiente;
        $this->token = $token;
    }

    public function getAmbiente(): string
    {
        return $this->ambiente;
    }

    public function sendPOST($uriMetodo, $data = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->server.$uriMetodo."&token=".$this->token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        if ($data){
//            dd($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->return_http_code = $http_code;
        $this->return_body = $body;

        $this->tratarRetorno();
    }

    public function sendGET($uriMetodo){
        $uriMetodo = $uriMetodo."&token=".$this->token;

        if (strpos($uriMetodo, '?') === false) {
            $uriMetodo = str_replace("&token","?token",$uriMetodo);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->server.$uriMetodo);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array());
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->return_http_code = $http_code;
        $this->return_body = $body;

        $this->tratarRetorno();
    }

    public function sendDELETE($uriMetodo){
        $uriMetodo = $uriMetodo."&token=".$this->token;

        if (strpos($uriMetodo, '?') === false) {
            $uriMetodo = str_replace("&token","?token",$uriMetodo);
        }

        $client = new GuzzleHttp\Client(['debug' => true,]);

// this option will also set the 'Content-Type' header.
        $response = $client->delete($uri, [
            'json' => $data,
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->server.$uriMetodo);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        echo $http_code;
        dd($body);

        $this->return_http_code = $http_code;
        $this->return_body = $body;

        $this->tratarRetorno();
    }

    protected function tratarRetorno(){
        $return = json_decode($this->return_body);

        if (isset($return->erros)){
            $this->erros = $return->erros;
        }else{
            $this->erros = null;
        }

        $this->retorno = $return;
    }

    public function justNumbers($str){
        return preg_replace("/[^0-9]/","",$str);
    }
}