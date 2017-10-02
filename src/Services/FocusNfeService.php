<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 08/02/2017
 * Time: 21:01
 */

namespace Devguar\OContainer\NotaFiscal\Services;


use Devguar\OContainer\Util\ConvertObjectArrayHelper;
use Symfony\Component\Yaml\Yaml;

abstract class FocusNfeService
{
    const AMBIENTE_PRODUCAO = 'P';
    const AMBIENTE_HOMOLOGACAO = 'H';

    const STATUS_AGUARDANDO_AUTORIZACAO = 'processando_autorizacao';
    const STATUS_ERRO_AUTORIZACAO = 'erro_autorizacao';
    const STATUS_AUTORIZADA = 'autorizada';

    const FORMATO_RETORNO_JSON = "json";
    const FORMATO_RETORNO_YAML = "yaml";

    private $ambiente;
    private $formatoComunicacao;
    private $token;

    private $server = "";

    public $return_http_code;
    public $return_body;
    public $erros;
    public $retorno;

    protected abstract function urlServerHomologacao();
    protected abstract function urlServerProducao();

    public function __construct($ambiente, $token, $formatoComunicacao)
    {
        if ($ambiente == self::AMBIENTE_PRODUCAO){
            $this->server = $this->urlServerProducao();
        }else{
            $this->server = $this->urlServerHomologacao();
        }

        $this->ambiente = $ambiente;
        $this->formatoComunicacao = $formatoComunicacao;
        $this->token = $token;
    }

    public function getAmbiente(): string
    {
        return $this->ambiente;
    }

    private function mountUrl($uri, $parametros = array()){
        $parametros['token'] = $this->token;
        $url = $this->server.$uri.'?'.http_build_query($parametros);
        return $url;
    }

    public function sendPOST($uri, $parametros, $data = null)
    {
        $url = $this->mountUrl($uri, $parametros);
        $client = new \GuzzleHttp\Client();
        $response = null;

        try{
            if ($data){
                if ($this->formatoComunicacao == self::FORMATO_RETORNO_YAML){
                    $data = Yaml::dump($data);
                    $response = $client->post($url,['body'=>$data]);
                }else{
                    $response = $client->post($url,['json'=>$data]);
                }
            }else{
                $response = $client->post($url);
            }
        }catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $response = $e->getResponse();
        }

        $this->tratarRetorno($response);
    }

    public function sendGET($uri, $parametros = null){
        $url = $this->mountUrl($uri, $parametros);
        $client = new \GuzzleHttp\Client();
        $response = null;

        try{
            $response = $client->get($url);
        }catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $response = $e->getResponse();
        }

        $this->tratarRetorno($response);
    }

    public function sendDELETE($uri, $parametros = null){
        $url = $this->mountUrl($uri, $parametros);
        $client = new \GuzzleHttp\Client();
        $response = null;

        try{
            $response = $client->delete($url);
        }catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $response = $e->getResponse();
        }

        $this->tratarRetorno($response);
    }

    protected function tratarRetorno($response){
        $this->return_http_code = $response->getStatusCode();
        $this->return_body = $response->getBody()->getContents();

        if ($this->formatoComunicacao == self::FORMATO_RETORNO_JSON){
            $return = json_decode($this->return_body);
        }else{
            $return = Yaml::parse($this->return_body);
        }

        $return = ConvertObjectArrayHelper::arrayToObject($return);

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