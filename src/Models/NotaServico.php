<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 08/02/2017
 * Time: 20:49
 */

namespace Devguar\OContainer\NotaFiscal\Models;


class NotaServico
{
    public $data_emissao;
    public $cliente; //Model Cliente
    public $servico; //Model Servico
    public $percentual_ir;
    public $texto_ir;
    public $percentual_iss;
    public $descontar_iss_total;
    public $forma_pagamento;
    public $meio_pagamento;
    public $parcelas; //Array de Model Parcela
    public $id_vendedor = null;
    public $percentual_comissao = null;
    public $condicoes;
}