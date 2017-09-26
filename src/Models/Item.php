<?php

namespace Devguar\OContainer\NotaFiscal\Models;

class Item
{
    public $numero_item;
    public $codigo_produto;
    public $descricao;
    public $cfop;
    public $unidade_comercial;
    public $quantidade_comercial;
    public $valor_unitario_comercial;
    public $valor_unitario_tributavel;
    public $unidade_tributavel;
    public $codigo_ncm;
    public $quantidade_tributavel;
    public $valor_bruto;
    public $icms_situacao_tributaria;
    public $icms_origem;
    public $pis_situacao_tributaria;
    public $cofins_situacao_tributaria;
    public $ipi_situacao_tributaria;
    public $ipi_codigo_enquadramento_legal;
}