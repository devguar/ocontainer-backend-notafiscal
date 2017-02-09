<?php

namespace Devguar\OContainer\NotaFiscal\Tests;

use Devguar\OContainer\NotaFiscal\Models;
use Devguar\OContainer\NotaFiscal\Services;

class NotaFiscalTest extends TestCase
{
    private $tokenTiny = "92aa324c599486438b9189b357784c84f7bdb598";

    private function carregarObjetoNotaFiscalExemplo(){
        $datetime = new \DateTime();

        $nota = new Models\NotaFiscal();
        $nota->tipo = "S";
        $nota->natureza_operacao = "Venda de Mercadorias";
        $nota->data_emissao = $datetime->format('d/m/Y');
        $nota->data_entrada_saida = $datetime->format('d/m/Y');
        $nota->hora_entrada_saida = $datetime->format('H:i:s');

        $cliente = new Models\Cliente();
        $cliente->codigo = "1235";
        $cliente->nome = "Contato Teste 2";
        $cliente->tipo_pessoa = "F";
        $cliente->cpf_cnpj = "22755777850";
        $cliente->ie = "";
        $cliente->rg = "1234567890";
        $cliente->endereco = "Rua Teste";
        $cliente->numero = "123";
        $cliente->complemento = "sala 2";
        $cliente->bairro = "Teste";
        $cliente->cep = "95700000";
        $cliente->cidade = "Bento Gonçalves";
        $cliente->uf = "RS";
        $cliente->fone = "5430553808";
        $cliente->email = "teste@teste.com.br";
        $cliente->atualizar_cliente = "N";

        $nota->cliente = $cliente;

        $itens = array();

        $item = new Models\Item();
        $item->codigo = "1234";
        $item->descricao = "Produto Teste 1";
        $item->unidade = "UN";
        $item->quantidade = "2";
        $item->valor_unitario = "50.25";
        $item->tipo = "P";
        $item->origem = "0";
        $item->numero_fci = "B01F70AF-10BF-4B1F-848C-65FF57F616FE";
        $item->ncm = "1234567890";
        $item->peso_bruto = "1.25";
        $item->peso_liquido = "1.15";
        $item->gtin_ean = "1234567890";
        $item->gtin_ean_embalagem = "";
        $item->codigo_lista_servicos = "";

        $object = new \StdClass();
        $object->item = $item;
        $itens[] = $object;

        $item = new Models\Item();
        $item->codigo = "1235";
        $item->descricao = "Produto Teste 2";
        $item->unidade = "UN";
        $item->quantidade = "4";
        $item->valor_unitario = "15.25";
        $item->tipo = "P";

        $object = new \StdClass();
        $object->item = $item;
        $itens[] = $object;

        $nota->itens = $itens;

        $nota->forma_pagamento = "multiplas";

        $parcelas = array();

        $parcela = new Models\Parcela();
        $parcela->dias = "30";
        $parcela->data = "29/11/2012";
        $parcela->valor = "53.84";
        $parcela->obs = "Obs Parcela 1";
        $parcela->forma_pagamento = "dinheiro";

        $object = new \StdClass();
        $object->parcela = $parcela;
        $parcelas[] = $object;

        $parcela = new Models\Parcela();
        $parcela->dias = "60";
        $parcela->data = "29/12/2012";
        $parcela->valor = "53.83";
        $parcela->obs = "Obs Parcela 2";
        $parcela->forma_pagamento = "boleto";
        $parcela->meio_pagamento = "Bradesco";

        $object = new \StdClass();
        $object->parcela = $parcela;
        $parcelas[] = $object;

        $parcela = new Models\Parcela();
        $parcela->dias = "90";
        $parcela->data = "27/01/2013";
        $parcela->valor = "53.83";
        $parcela->obs = "Obs Parcela 3";
        $parcela->forma_pagamento = "credito";
        $parcela->meio_pagamento = "Gateway 123";

        $object = new \StdClass();
        $object->parcela = $parcela;
        $parcelas[] = $object;

        $nota->parcelas = $parcelas;

        $transportador = new Models\Transportador();
        $transportador->codigo = "2222";
        $transportador->nome = "Transportador teste";
        $transportador->tipo_pessoa = "J";
        $transportador->cpf_cnpj = "00000000000000";
        $transportador->ie = "123345";
        $transportador->endereco = "Rua Teste";
        $transportador->cidade = "Bento Gonçalves";
        $transportador->uf = "RS";

        $object = new \StdClass();
        $object->transportador = $transportador;
        $nota->transportador = $object;

        $nota->frete_por_conta = "R";
        $nota->placa_veiculo = "AAA-0000";
        $nota->uf_veiculo = "RS";
        $nota->quantidade_volumes = "10";
        $nota->especie_volumes = "Caixas";
        $nota->marca_volumes = "";
        $nota->numero_volumes = "";
        $nota->valor_desconto = "45.45";
        $nota->valor_frete = "35.45";
        $nota->valor_seguro = "4.00";
        $nota->valor_despesas = "1.00";
        $nota->obs = "Observações da nota";

        return $nota;
    }

    public function testCarregandoObjetoNotaFiscal(){
        $nota = $this->carregarObjetoNotaFiscalExemplo();

        $notaFiscalService = new Services\NotaFiscalService($this->tokenTiny);
        $retorno = $notaFiscalService->incluirNota($nota);

        $this->assertEquals($retorno->retorno->status_processamento, '3');
        $this->assertEquals($retorno->retorno->status, 'OK');

        $this->assertFalse(isset($retorno->retorno->registros->erros));
        $this->assertTrue(isset($retorno->retorno->registros->registro));
        $this->assertFalse(isset($retorno->retorno->registros->registro->erros));
    }

    public function testCarregandoObjetoNotaFiscalSemCliente(){
        $nota = $this->carregarObjetoNotaFiscalExemplo();

        unset($nota->cliente);

        $notaFiscalService = new Services\NotaFiscalService($this->tokenTiny);
        $retorno = $notaFiscalService->incluirNota($nota);

        $this->assertNotEquals($retorno->retorno->status_processamento, '3');
        $this->assertEquals($retorno->retorno->status, 'OK');

        $this->assertTrue(isset($retorno->retorno->registros->registro->erros));

        $this->assertEquals('O nome do cliente deve ser informado',$retorno->retorno->registros->registro->erros[0]->erro);
    }

    public function testCarregandoObjetoNotaFiscalSemItens(){
        $nota = $this->carregarObjetoNotaFiscalExemplo();
        $nota->itens = array();

        $notaFiscalService = new Services\NotaFiscalService($this->tokenTiny);
        $retorno = $notaFiscalService->incluirNota($nota);

        $this->assertNotEquals($retorno->retorno->status_processamento, '3');
        $this->assertEquals($retorno->retorno->status, 'OK');

        $this->assertTrue(isset($retorno->retorno->registros->registro->erros));

        $this->assertContains('informar ao menos um item para a nota fiscal',$retorno->retorno->registros->registro->erros[0]->erro);
    }
}