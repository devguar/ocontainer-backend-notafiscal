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

        $retorno = $this->enviarREST($url, $data);

        if ($retorno->retorno->status_processamento == 3){
            return $retorno->retorno->registros[0]->registro;
        }else{
            $this->erro = $this->buscarErro($retorno);
            return null;
        }
    }

    function pesquisarNotas($pagina){
        $objeto = new \StdClass();

        $url = $this->metodos_base_url.'nota.servico.pesquisa.php';
        $nota = json_encode($objeto);
        $data = "token=$this->token&pagina=$pagina&formato=JSON";

        return $this->enviarREST($url, $data);
    }

    function obterNota($id_externo){
        $url = $this->metodos_base_url.'nota.servico.obter.php';
        $data = "token=$this->token&id=$id_externo&formato=JSON";

        $retorno = $this->enviarREST($url, $data);

        if ($retorno->retorno->status_processamento == 3){
            return $retorno->retorno->nota_fiscal;
        }else{
            $this->erro = $this->buscarErro($retorno);
            return null;
        }
    }

    function statusNota($id_externo){
        $notaFiscal = $this->obterNota($id_externo);

        if ($notaFiscal){
            return $notaFiscal->descricao_situacao;
        }

        return null;
    }
}