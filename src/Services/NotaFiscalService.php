<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 08/02/2017
 * Time: 21:02
 */

namespace Devguar\OContainer\NotaFiscal\Services;


use Devguar\OContainer\NotaFiscal\Models\NotaFiscal;

class NotaFiscalService extends TinyService
{
    function incluirNota(NotaFiscal $nota){
        $objeto = new \StdClass();
        $objeto->nota_fiscal = $nota;

        $url = $this->metodos_base_url.'nota.fiscal.incluir.php';
        $nota = json_encode($objeto);
        $data = "token=$this->token&nota=$nota&formato=JSON";

//        die($nota);

        return $this->enviarREST($url, $data);
    }



}