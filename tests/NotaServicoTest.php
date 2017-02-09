<?php

namespace Devguar\OContainer\NotaFiscal\Tests;

use Devguar\OContainer\NotaFiscal\Models;
use Devguar\OContainer\NotaFiscal\Services;

class NotaServicoTest extends TestCase
{
    private $tokenTiny = "92aa324c599486438b9189b357784c84f7bdb598";

    private function carregarObjetoNotaServicoExemplo(){
        $datetime = new \DateTime();

        $nota = new Models\NotaServico();
        $nota->data_emissao = $datetime->format('d/m/Y');

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

        $servico = new Models\Servico();
        $servico->descricao = "Serviço teste";
        $servico->valor_servico = "150.96";
        $servico->codigo_lista_servico = "1.02";

        $nota->servico = $servico;

        $nota->percentual_ir = "1.5";
        $nota->texto_ir = "IR Isento Cfe. Lei nro. 9430/96 Art.64";
        $nota->percentual_iss = "2";
        $nota->descontar_iss_total = "N";
        $nota->forma_pagamento = "boleto";
        $nota->meio_pagamento = "Bradesco X";

        $parcelas = array();

        $parcela = new Models\Parcela();
        $parcela->dias = "30";
        $parcela->data = "29/11/2012";
        $parcela->valor = "50.32";
        $parcela->obs = "Obs Parcela 1";
        $parcela->forma_pagamento = "dinheiro";

        $object = new \StdClass();
        $object->parcela = $parcela;
        $parcelas[] = $object;

        $parcela = new Models\Parcela();
        $parcela->dias = "60";
        $parcela->data = "29/12/2012";
        $parcela->valor = "50.32";
        $parcela->obs = "Obs Parcela 2";
        $parcela->forma_pagamento = "boleto";
        $parcela->meio_pagamento = "Bradesco";

        $object = new \StdClass();
        $object->parcela = $parcela;
        $parcelas[] = $object;

        $parcela = new Models\Parcela();
        $parcela->dias = "90";
        $parcela->data = "27/01/2013";
        $parcela->valor = "50.32";
        $parcela->obs = "Obs Parcela 3";
        $parcela->forma_pagamento = "credito";
        $parcela->meio_pagamento = "Gateway 123";

        $object = new \StdClass();
        $object->parcela = $parcela;
        $parcelas[] = $object;

        $nota->parcelas = $parcelas;
        $nota->condicoes = "Teste";

        return $nota;
    }

    public function testCarregandoObjetoNotaFiscal(){
        $nota = $this->carregarObjetoNotaServicoExemplo();

        $notaFiscalService = new Services\NotaServicoService($this->tokenTiny);
        $retorno = $notaFiscalService->incluirNota($nota);

        $this->assertEquals($retorno->retorno->status_processamento, '3');
        $this->assertEquals($retorno->retorno->status, 'OK');

        $this->assertFalse(isset($retorno->retorno->registros->erros));
        $this->assertTrue(isset($retorno->retorno->registros->registro));
        $this->assertFalse(isset($retorno->retorno->registros->registro->erros));
    }
//
//    public function testCarregandoObjetoNotaFiscalSemCliente(){
//        $nota = $this->carregarObjetoNotaFiscalExemplo();
//
//        unset($nota->cliente);
//
//        $notaFiscalService = new Services\NotaFiscalService($this->tokenTiny);
//        $retorno = $notaFiscalService->incluirNota($nota);
//
//        $this->assertNotEquals($retorno->retorno->status_processamento, '3');
//        $this->assertEquals($retorno->retorno->status, 'OK');
//
//        $this->assertTrue(isset($retorno->retorno->registros->registro->erros));
//
//        $this->assertEquals('O nome do cliente deve ser informado',$retorno->retorno->registros->registro->erros[0]->erro);
//    }
//
//    public function testCarregandoObjetoNotaFiscalSemItens(){
//        $nota = $this->carregarObjetoNotaFiscalExemplo();
//        $nota->itens = array();
//
//        $notaFiscalService = new Services\NotaFiscalService($this->tokenTiny);
//        $retorno = $notaFiscalService->incluirNota($nota);
//
//        $this->assertNotEquals($retorno->retorno->status_processamento, '3');
//        $this->assertEquals($retorno->retorno->status, 'OK');
//
//        $this->assertTrue(isset($retorno->retorno->registros->registro->erros));
//
//        $this->assertContains('informar ao menos um item para a nota fiscal',$retorno->retorno->registros->registro->erros[0]->erro);
//    }
}