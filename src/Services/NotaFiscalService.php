<?php

namespace Devguar\OContainer\NotaFiscal\Services;

use Devguar\OContainer\NotaFiscal\Models\NotaFiscal;

class NotaFiscalService extends FocusNfeService
{
    public function enviar($nota)
    {
        $nfe = (array) $nota;
        $this->sendPOST("autorizar.json?ref=".$nota->referencia, $nfe);

        dd($this->return_body);
    }

    public function consultar($referencia)
    {
        $this->sendGET("consultar.json?ref=".$referencia);

        dd($this->return_body);
    }

    public function cancelar($referencia, $justificativa){
        $this->sendPOST("cancelar?ref=".$referencia."&justificativa=".$justificativa);

        dd($this->return_body);
    }
}