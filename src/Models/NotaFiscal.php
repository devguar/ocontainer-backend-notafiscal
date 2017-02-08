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
    public $tipo;
    public $natureza_operacao;
    public $data_emissao;
    public $data_entrada_saida;
    public $hora_entrada_saida;
    public $cliente; //Model Cliente
    public $itens; //Array de Model Item
    public $forma_pagamento;
    public $parcelas; //Array de Model Parcela
    public $frete_por_conta;
    public $placa_veiculo;
    public $uf_veiculo;
    public $quantidade_volumes;
    public $especie_volumes;
    public $marca_volumes;
    public $numero_volumes;
    public $valor_desconto;
    public $valor_frete;
    public $valor_seguro;
    public $valor_despesas;
    public $nf_produtor_rural = null;
    public $id_vendedor = null;
    public $numero_pedido_ecommerce = null;
    public $obs;
}