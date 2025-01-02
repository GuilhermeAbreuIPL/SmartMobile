<?php


namespace common\tests\Unit;

use common\tests\UnitTester;
use common\models\Morada;
use common\models\User;

class MoradaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testCreateMoradaWithValidData()
    {
        $morada = new Morada([
            'rua' => 'Rua de Teste',
            'localidade' => 'Localidade Teste',
            'codpostal' => '1234-567',
            'user_id' => 1, // ID de usuário válido
        ]);

        $this->assertTrue($morada->validate(), 'A morada com dados válidos deveria ser validada.');
    }

    public function testCreateMoradaWithInvalidData()
    {
        $morada = new Morada([
            'rua' => '', // Campo obrigatório em branco
            'localidade' => str_repeat('a', 101), // Excede o limite de 100 caracteres
            'codpostal' => '12345678A', // Formato inválido
            'user_id' => 'x', // ID de usuário inexistente
        ]);

        $this->assertFalse($morada->validate(), 'A morada com dados inválidos não deveria ser validada.');
        $this->assertArrayHasKey('rua', $morada->errors, 'Deveria ter erro para o campo "rua".');
        $this->assertArrayHasKey('localidade', $morada->errors, 'Deveria ter erro para o campo "localidade".');
        $this->assertArrayHasKey('codpostal', $morada->errors, 'Deveria ter erro para o campo "codpostal".');
        $this->assertArrayHasKey('user_id', $morada->errors, 'Deveria ter erro para o campo "user_id".');
    }

    public function testCreateMoradaWithMinimalData()
    {
        $morada = new Morada([
            'rua' => 'Rua Simples',
        ]);

        $this->assertTrue($morada->validate(), 'A morada deveria ser válida com apenas o campo obrigatório "rua".');
    }

    public function testRelationshipWithUser()
    {
        // Criar um usuário fictício para o teste
        $user = new User([
            'id' => 90,
            'username' => 'teste_user',
        ]);
        $user->save(false);

        $morada = new Morada([
            'rua' => 'Rua do Usuário',
            'localidade' => 'Localidade do Usuário',
            'codpostal' => '1234-567',
            'user_id' => $user->id,
        ]);

        $this->assertTrue($morada->validate(), 'A morada com referência a um usuário válido deveria ser validada.');
        $this->assertEquals($user->id, $morada->user_id, 'O campo "user_id" deveria corresponder ao ID do usuário associado.');
    }
}
