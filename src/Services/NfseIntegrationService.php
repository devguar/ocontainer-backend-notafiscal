<?php

namespace Devguar\OContainer\NotaFiscal\Services;

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
        $this->sendPOST("nfse?ref=".$nota['referencia'], \yaml_emit($nota));
    }

    public function consultar($referencia)
    {
        $this->sendGET("consultar.json?ref=".$referencia);
    }

    public function cancelar($referencia, $justificativa){
        $this->sendPOST("cancelar?ref=".$referencia."&justificativa=".$justificativa);
    }
}