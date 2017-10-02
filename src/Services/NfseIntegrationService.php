<?php

namespace Devguar\OContainer\NotaFiscal\Services;

use Symfony\Component\Yaml\Yaml;

class NfseIntegrationService extends FocusNfeService
{
    protected function urlServerHomologacao()
    {
        return "http://homologacao.acrasnfe.acras.com.br/";
    }

    protected function urlServerProducao()
    {
        return "https://api.focusnfe.com.br/";
    }

    public function enviar($nota)
    {
//        dd(Yaml::dump($nota));

        $this->sendPOST("nfse?ref=".$nota['referencia'], Yaml::dump($nota));
    }

    protected function tratarRetorno(){
        $return = (object) Yaml::parse($this->return_body);
        $return = json_decode(json_encode($return));

        if (isset($return->erros)){
            $this->erros = $return->erros;
        }else{
            $this->erros = null;
        }

        $this->retorno = $return;
    }

    public function consultar($referencia)
    {
        $this->sendGET("nfse/".$referencia);
    }

    public function cancelar($referencia, $justificativa){
        $this->sendPOST("cancelar?ref=".$referencia."&justificativa=".$justificativa);
    }
}