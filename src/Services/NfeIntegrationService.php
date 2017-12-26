<?php

namespace Devguar\OContainer\NotaFiscal\Services;

use Devguar\OContainer\NotaFiscal\Exceptions\InvalidNfeParameter;
use Devguar\OContainer\Util\ValidaCPFCNPJ;

class NfeIntegrationService extends FocusNfeService
{
    public function __construct($ambiente, $token)
    {
        parent::__construct($ambiente, $token, parent::FORMATO_RETORNO_JSON);
    }

    protected function urlServerHomologacao()
    {
        return "http://homologacao.acrasnfe.acras.com.br";
    }

    protected function urlServerProducao()
    {
        return "https://api.focusnfe.com.br";
    }

    public function enviar($nota)
    {
        $this->preValidacao($nota);
        $ref = $nota->referencia;
        unset($nota->referencia);
        $this->sendPOST("/nfe2/autorizar.json",['ref'=>$ref], $nota);
    }

    public function validar($nota){
        $this->preValidacao($nota);
    }

    public function consultar($referencia)
    {
        $this->sendGET("/nfe2/consultar.json",['ref'=>$referencia]);
    }

    public function cancelar($referencia, $justificativa){
        $this->sendPOST("/nfe2/cancelar",['ref'=>$referencia,'justificativa'=>$justificativa]);
    }

    private function preValidacao($nfe){
        if (!$nfe->data_emissao){
            throw new InvalidNfeParameter("Data de emissão inválida.");
        }

        if (!$nfe->natureza_operacao){
            throw new InvalidNfeParameter("Natureza de operação inválida.");
        }

        if (!$nfe->natureza_operacao){
            throw new InvalidNfeParameter("Natureza de operação inválida.");
        }

        if (!$nfe->cnpj_emitente) {
            throw new InvalidNfeParameter("CNPJ do emitende não informado.");
        }

        $cpf_cnpj = new ValidaCPFCNPJ($nfe->cnpj_emitente);
        if (!$cpf_cnpj->valida()) {
            throw new InvalidNfeParameter("CNPJ do emitente inválido.");
        }

        if ($nfe->cpf_destinatario){
            $cpf_cnpj = new ValidaCPFCNPJ($nfe->cpf_destinatario);
            if (!$cpf_cnpj->valida()) {
                throw new InvalidNfeParameter("CPF do destinatario inválido.");
            }
        }elseif ($nfe->cnpj_destinatario){
            $cpf_cnpj = new ValidaCPFCNPJ($nfe->cnpj_destinatario);
            if (!$cpf_cnpj->valida()) {
                throw new InvalidNfeParameter("CNPJ do destinatario inválido.");
            }
        }else{
            throw new InvalidNfeParameter("Destinarário sem CPF ou CNPJ.");
        }

        if (!$nfe->logradouro_destinatario) {
            throw new InvalidNfeParameter("Endereço do destinatário inválido.");
        }

        if (!$nfe->bairro_destinatario) {
            throw new InvalidNfeParameter("Bairro do destinatário inválido.");
        }

        if (!$nfe->municipio_destinatario) {
            throw new InvalidNfeParameter("Município do destinatário inválido.");
        }

        if (!$nfe->uf_destinatario) {
            throw new InvalidNfeParameter("Estado (UF) do destinatário inválido.");
        }

        if (!$nfe->items || count($nfe->items) == 0) {
            throw new InvalidNfeParameter("Nota fiscal sem produtos.");
        }

        foreach ($nfe->items as $item) {
            if (!$item->codigo_produto){
                throw new InvalidNfeParameter("Produto número ".$item->numero_item." sem código.");
            }

            if (!$item->descricao){
                throw new InvalidNfeParameter("Produto número ".$item->numero_item." sem descrição.");
            }

            if (!$item->cfop){
                throw new InvalidNfeParameter("Produto número ".$item->numero_item." sem CFOP.");
            }

            if (!$item->unidade_comercial || !$item->unidade_tributavel){
                throw new InvalidNfeParameter("Produto número ".$item->numero_item." sem unidade comercial.");
            }

            if (!$item->quantidade_comercial){
                throw new InvalidNfeParameter("Produto número ".$item->numero_item." sem quantidade.");
            }

            if (!$item->valor_unitario_comercial || !$item->valor_unitario_tributavel || !$item->valor_bruto){
                throw new InvalidNfeParameter("Produto número ".$item->numero_item." sem valor unitário ou bruto.");
            }

            if (!$item->codigo_ncm){
                throw new InvalidNfeParameter("Produto número ".$item->numero_item." sem NCM.");
            }
        }
    }

    protected function tratarRetorno($response)
    {
        parent::tratarRetorno($response);

        if ($this->retorno){
            if ($this->retorno->caminho_xml_nota_fiscal){
                $this->retorno->caminho_xml_nota_fiscal = $this->server.$this->retorno->caminho_xml_nota_fiscal;
            }

            if ($this->retorno->caminho_xml_cancelamento){
                $this->retorno->caminho_xml_cancelamento = $this->server.$this->retorno->caminho_xml_cancelamento;
            }

            if ($this->retorno->caminho_danfe){
                $this->retorno->caminho_danfe = $this->server.$this->retorno->caminho_danfe;
            }
        }
    }
}