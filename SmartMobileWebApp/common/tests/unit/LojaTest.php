<?php

namespace common\tests\Unit;

use common\models\Loja;
use common\tests\UnitTester;

/**
 * Testes unitários para a classe Loja.
 */
class LojaTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testCreateLojaWithValidData()
    {
        $loja = new Loja([
            'nome' => 'Loja Teste',
            'contacto' => '123456789',
            'rua' => 'Rua Teste 123',
            'localidade' => 'Localidade Teste',
            'codpostal' => '1234-567'
        ]);

        $this->assertTrue($loja->validate(), 'Se os dados estiverem corretos a loja é valida');
    }

    public function testCreateLojaWithInvalidData()
    {
        $loja = new Loja([
            'nome' => 'Loja de Teste',
            'contacto' => '123456789',
            'rua' => '', // campo obrigatório em branco
            'localidade' => 'Localidade Teste',
            'codpostal' => '' // campo obrigatório em branco
        ]);

        $this->assertFalse($loja->validate(), 'A loja com campos obrigatórios em branco não deve ser valida');
        $this->assertArrayHasKey('rua', $loja->errors, 'Deve ter erro para o campo "rua"');
        $this->assertArrayHasKey('codpostal', $loja->errors, 'Deve ter erro para o campo "codpostal"');
    }

    public function testLojaWithMaxStringLength()
    {
        $loja = new Loja([
            'nome' => str_repeat('a', 46), // excede o limite de 45 caracteres
            'contacto' => '123456789',
            'rua' => str_repeat('a', 86), // excede o limite de 85 caracteres
            'localidade' => 'Localidade Teste',
            'codpostal' => '1234-567'
        ]);

        $this->assertFalse($loja->validate(), 'A loja com campos com tamanho máximo excedido não deve ser valida');
        $this->assertArrayHasKey('nome', $loja->errors, 'Deve ter erro para o campo "nome"');
        $this->assertArrayHasKey('rua', $loja->errors, 'Deve ter erro para o campo "rua"');
    }
}
