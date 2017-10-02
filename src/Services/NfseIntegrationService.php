<?php

namespace Devguar\OContainer\NotaFiscal\Services;

use Devguar\OContainer\NotaFiscal\Exceptions\InvalidNfeParameter;
use Devguar\OContainer\Util\ConvertObjectArrayHelper;
use Devguar\OContainer\Util\ValidaCPFCNPJ;
use Symfony\Component\Yaml\Yaml;

class NfseIntegrationService extends FocusNfeService
{
    public function __construct($ambiente, $token)
    {
        parent::__construct($ambiente, $token, parent::FORMATO_RETORNO_YAML);
    }

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
        $this->preValidacao($nota);
        $this->sendPOST("nfse", ['ref'=>$nota->referencia], ConvertObjectArrayHelper::objectToArray($nota));
    }

    public function validar($nota){
        $this->preValidacao($nota);
    }

    public function consultar($referencia)
    {
        $this->sendGET("nfse/".$referencia);
    }

    public function cancelar($referencia, $justificativa){
        $this->sendDELETE("nfse/".$referencia, ['justificativa'=>$justificativa]);
    }

    private function preValidacao($nfe){
        if (!$nfe->data_emissao){
            throw new InvalidNfeParameter("Data de emissão inválida.");
        }

        if (!$nfe->prestador){
            throw new InvalidNfeParameter("Faltando informações do prestador.");
        }

        if (!$nfe->prestador->cnpj) {
            throw new InvalidNfeParameter("CNPJ do prestador inexistente.");
        }

        $cpf_cnpj = new ValidaCPFCNPJ($nfe->prestador->cnpj);
        if (!$cpf_cnpj->valida()) {
            throw new InvalidNfeParameter("CNPJ do prestador inválido.");
        }

        if (!$nfe->prestador->inscricao_municipal) {
            throw new InvalidNfeParameter("Inscrição municipal do prestador inexistente.");
        }

        if (!$nfe->prestador->codigo_municipio) {
            throw new InvalidNfeParameter("Município do prestador inexistente.");
        }

        if (!$nfe->servico){
            throw new InvalidNfeParameter("Faltando informações do serviço.");
        }

        if (!$nfe->servico->aliquota){
            throw new InvalidNfeParameter("Alíquota de ISS não informada.");
        }

        if (!$nfe->servico->valor_liquido || !$nfe->servico->valor_servicos || !$nfe->servico->base_calculo){
            throw new InvalidNfeParameter("Valor do serviço inválido.");
        }

        if (!$nfe->tomador){
            throw new InvalidNfeParameter("Faltando informações do tomador.");
        }

        if ($nfe->tomador->cpf){
            $cpf_cnpj = new ValidaCPFCNPJ($nfe->tomador->cpf);
            if (!$cpf_cnpj->valida()) {
                throw new InvalidNfeParameter("CPF do tomador inválido.");
            }
        }elseif ($nfe->tomador->cnpj){
            $cpf_cnpj = new ValidaCPFCNPJ($nfe->tomador->cnpj);
            if (!$cpf_cnpj->valida()) {
                throw new InvalidNfeParameter("CNPJ do tomador inválido.");
            }
        }else{
            throw new InvalidNfeParameter("Tomador sem CPF ou CNPJ.");
        }

        if (!$nfe->tomador->endereco) {
            throw new InvalidNfeParameter("Tomador sem endereço.");
        }

        if (!$nfe->tomador->endereco->codigo_municipio) {
            throw new InvalidNfeParameter("Município do tomador inexistente.");
        }

        if (!$nfe->tomador->endereco->uf) {
            throw new InvalidNfeParameter("UF do tomador inexistente.");
        }
    }
}