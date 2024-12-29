<?php


namespace common\tests\Unit;

use common\tests\UnitTester;
use common\models\Promocao;

class PromocaoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testCreatePromocaoWithValidData()
    {
        $promocao = new Promocao([
            'nome' => 'Promoção Teste',
            'descricao' => 'Descrição da promoção de teste',
            'descontopercentual' => 20.5,
        ]);

        $this->assertTrue($promocao->validate(), 'A promoção com dados válidos deveria ser validada.');
    }

    public function testCreatePromocaoWithInvalidData()
    {
        $promocao = new Promocao([
            'nome' => str_repeat('a', 101), // excede o limite de 100 caracteres
            'descricao' => null,
            'descontopercentual' => 'invalido', // valor não numérico
        ]);

        $this->assertFalse($promocao->validate(), 'A promoção com dados inválidos não deveria ser validada.');
        $this->assertArrayHasKey('nome', $promocao->errors, 'Deveria ter erro para o campo "nome".');
        $this->assertArrayHasKey('descontopercentual', $promocao->errors, 'Deveria ter erro para o campo "descontopercentual".');
    }

}
