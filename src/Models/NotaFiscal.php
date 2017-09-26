<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 08/02/2017
 * Time: 20:49
 */

namespace Devguar\OContainer\NotaFiscal\Models;


class NotaFiscal
{
    public $referencia;
    public $natureza_operacao;
    public $forma_pagamento;
    public $data_emissao;
    public $tipo_documento;
    public $finalidade_emissao;
    public $cnpj_emitente;
    public $inscricao_estadual_emitente;
    public $nome_destinatario;
    public $cnpj_destinatario;
    public $inscricao_estadual_destinatario;
    public $logradouro_destinatario;
    public $numero_destinatario;
    public $bairro_destinatario;
    public $municipio_destinatario;
    public $uf_destinatario;
    public $pais_destinatario;
    public $cep_destinatario;
    public $icms_base_calculo;
    public $icms_valor_total;
    public $icms_base_calculo_st;
    public $icms_valor_total_st;
    public $icms_modalidade_base_calculo;
    public $icms_valor;
    public $valor_frete;
    public $valor_seguro;
    public $valor_total;
    public $valor_produtos;
    public $valor_ipi;
    public $modalidade_frete;
    public $informacoes_adicionais_contribuinte;
    public $nome_transportador;
    public $cnpj_transportador;
    public $endereco_transportador;
    public $municipio_transportador;
    public $uf_transportador;
    public $inscricao_estadual_transportador;
    public $items;
    public $volumes;
    public $duplicatas;

    /*
     *             "natureza_operacao" => $nota->natureza_operacao, //"Remessa de Produtos",
            "forma_pagamento" => $nota->forma_pagamento, //"0",
            "data_emissao" => $nota->data_emissao, //"2017-07-26T13:55:00-03:00",
            "tipo_documento" => $nota->tipo_documento, //"1",
            "finalidade_emissao" => $nota->finalidade_emissao, //"1",
            "cnpj_emitente" => $nota->cnpj_emitente, //"51916585000125",
            "inscricao_estadual_emitente" => $nota->inscricao_estadual_emitente, //"101942171617",
            "nome_destinatario" => $nota->nome_destinatario, //"NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL",
            "cnpj_destinatario" => $nota->cnpj_destinatario, //"51916585000125",
            "inscricao_estadual_destinatario" => $nota->inscricao_estadual_destinatario, //"101942171617",
            "logradouro_destinatario" => $nota->logradouro_destinatario, //"SMAS 6580 PARKSHOPPING",
            "numero_destinatario" => $nota->numero_destinatario, //"134",
            "bairro_destinatario" => $nota->bairro_destinatario, //"Zona Industrial",
            "municipio_destinatario" => $nota->municipio_destinatario, //"Brasilia",
            "uf_destinatario" => $nota->uf_destinatario, //"DF",
            "pais_destinatario" => $nota->pais_destinatario, //"Brasil",
            "cep_destinatario" => $nota->cep_destinatario, //"71219900",
            "icms_base_calculo" => $nota->icms_base_calculo, //"0",
            "icms_valor_total" => $nota->icms_valor_total, //"0",
            "icms_base_calculo_st" => $nota->icms_base_calculo_st, //"0",
            "icms_valor_total_st" => $nota->icms_valor_total_st, //"0",
            "icms_modalidade_base_calculo" => $nota->icms_modalidade_base_calculo, //"0",
            "icms_valor" => $nota->icms_valor, //"0",
            "valor_frete" => $nota->valor_frete, //"0.0000",
            "valor_seguro" => $nota->valor_seguro, //"0",
            "valor_total" => $nota->valor_total, //"2241.66",
            "valor_produtos" => $nota->valor_produtos, //"2241.66",
            "valor_ipi" => $nota->valor_ipi, //"0",
            "modalidade_frete" => $nota->modalidade_frete, //"0",
            "informacoes_adicionais_contribuinte" => $nota->informacoes_adicionais_contribuinte, //"Não Incidência ICMS conforme Decisão...",
            "nome_transportador" => $nota->nome_transportador, //"ACME LTDA",
            "cnpj_transportador" => $nota->cnpj_transportador, //"51916585000125",
            "endereco_transportador" => $nota->endereco_transportador, //"RUA MARQUES RIBEIRO, 225",
            "municipio_transportador" => $nota->municipio_transportador, //"SÃO PAULO",
            "uf_transportador" => $nota->uf_transportador, //"SP",
            "inscricao_estadual_transportador" => $nota->inscricao_estadual_transportador, //"101942171617",
     */
}