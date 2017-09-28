<?php

namespace Devguar\OContainer\NotaFiscal\Services;

use Devguar\OContainer\NotaFiscal\Models\Nfe;

class NfeIntegrationService extends FocusNfeService
{
    protected function urlServerHomologacao()
    {
        return "http://homologacao.acrasnfe.acras.com.br/nfe2/";
    }

    protected function urlServerProducao()
    {
        return "https://api.focusnfe.com.br/nfe2/";
    }

    public function enviar($nota)
    {
        $nfe = (array) $nota;
        $this->sendPOST("autorizar.json?ref=".$nota->referencia, json_encode($nfe));
    }

    public function consultar($referencia)
    {
        $this->sendGET("consultar.json?ref=".$referencia);
    }

    public function cancelar($referencia, $justificativa){
        $this->sendPOST("cancelar?ref=".$referencia."&justificativa=".$justificativa);
    }
}