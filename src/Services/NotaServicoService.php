<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 08/02/2017
 * Time: 21:02
 */

namespace Devguar\OContainer\NotaFiscal\Services;


use Devguar\OContainer\NotaFiscal\Models\NotaServico;

class NotaServicoService extends TinyService
{
    function incluirNota(NotaServico $nota){
        $objeto = new \StdClass();
        $objeto->nota_servico = $nota;

        $url = $this->metodos_base_url.'nota.servico.incluir.php';
        $nota = json_encode($objeto);
        $data = "token=$this->token&nota=$nota&formato=JSON";

//        die($nota);

        return $this->enviarREST($url, $data);
    }



}