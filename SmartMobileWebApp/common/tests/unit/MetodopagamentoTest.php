<?php


namespace common\tests\Unit;

use common\tests\UnitTester;
use common\models\MetodoPagamento;
use common\models\Fatura;

class MetodopagamentoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testCreateMetodoPagamentoWithValidData()
    {
        $metodo = new MetodoPagamento([
            'nome' => 'IBAN',
            'descricao' => 'Transferência bancária',
        ]);

        $this->assertTrue($metodo->validate(), 'O método de pagamento com dados válidos deveria ser validado.');
    }

    public function testCreateMetodoPagamentoWithInvalidData()
    {
        $metodo = new MetodoPagamento([
            'nome' => str_repeat('a', 46), // Excede o limite de 45 caracteres
            'descricao' => ['invalid_array'], // Tipo inválido (deve ser string)
        ]);

        $this->assertFalse($metodo->validate(), 'O método de pagamento com dados inválidos não deveria ser validado.');
        $this->assertArrayHasKey('nome', $metodo->errors, 'Deveria ter erro para o campo "nome".');
        $this->assertArrayHasKey('descricao', $metodo->errors, 'Deveria ter erro para o campo "descricao".');
    }

    public function testCreateMetodoPagamentoWithMinimalData()
    {
        $metodo = new MetodoPagamento([
            'nome' => 'PayPal',
        ]);

        $this->assertTrue($metodo->validate(), 'O método de pagamento deveria ser válido com apenas o campo opcional "nome".');
    }

}
