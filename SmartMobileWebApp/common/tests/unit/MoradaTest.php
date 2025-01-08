<?php

namespace common\tests\unit;

Use common\fixtures\MoradaFixture;
Use common\fixtures\UserFixture;
use common\tests\UnitTester;
use common\models\Morada;

class MoradaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    public function _fixtures()
    {
        return [
            'moradas' => [
                'class' => MoradaFixture::class,
                'dataFile' => codecept_data_dir() . 'morada.php'
            ],
            'users' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

/*
    public function getUser()
    {
        //criar um user_id 1 válido
        $user = new User();

        $user->username = 'teste' . $user->id;
        $user->email = 'teste' . $user->id . '@teste.com';
        $user->setPassword('teste' . $user->id);
        $user->generateAuthKey();
        $user->save();

        return $user->id;
    }*/

    public function testValidationWithInvalidData()
    {
        $model = new Morada();

        // Teste com dados inválidos

        $model->rua = str_repeat('a', 86);
        $this->assertFalse($model->validate(['rua']), 'Rua não deveria ter mais de 85 caracteres.');

        $model->localidade = str_repeat('a', 101);
        $this->assertFalse($model->validate(['localidade']), 'Localidade não deveria ter mais de 100 caracteres.');

        $model->codpostal = '123456789';
        $this->assertFalse($model->validate(['codpostal']), 'Código Postal não deveria ter mais de 8 caracteres.');

        // Teste com dados required

        $model->rua = null;
        $this->assertFalse($model->validate(['rua']), 'Rua é obrigatória.');

        $model->localidade = null;
        $this->assertFalse($model->validate(['localidade']), 'Localidade é obrigatória.');

        $model->codpostal = null;
        $this->assertFalse($model->validate(['codpostal']), 'Código Postal é obrigatório.');

        $model->user_id = null;
        $this->assertFalse($model->validate(['user_id']), 'User_id é obrigatório.');

        // Teste com dados de tipo errado

        $model->rua = 123;
        $this->assertFalse($model->validate(['rua']), 'Rua não deveria ser um número.');

        $model->localidade = 123;
        $this->assertFalse($model->validate(['localidade']), 'Localidade não deveria ser um número.');

        $model->codpostal = 123;
        $this->assertFalse($model->validate(['codpostal']), 'Código Postal não deveria ser um número.');

        $model->user_id = 'string';
        $this->assertFalse($model->validate(['user_id']), 'User_id não deveria ser uma string.');

    }

    public function testValidationWithValidData()
    {
        $user = $this->tester->grabFixture('users', 'user1');
        $model = new Morada();

        // Teste com dados válidos

        $model->rua = 'Rua de Teste';
        $this->assertTrue($model->validate(['rua']), 'Rua deveria ser válida.');

        $model->localidade = 'Localidade de Teste';
        $this->assertTrue($model->validate(['localidade']), 'Localidade deveria ser válida.');

        $model->codpostal = '1234-567';
        $this->assertTrue($model->validate(['codpostal']), 'Código Postal deveria ser válido.');

        $model->user_id = $user->id;

        $this->assertTrue($model->validate(['user_id']), 'User_id deveria ser válido.');

    }

    public function testCreateMoradaWithValidData()
    {
        $user = $this->tester->grabFixture('users', 'user1');
        $morada = new Morada();

        $morada->rua = 'Rua de Teste';
        $this->assertTrue($morada->validate(['rua']), 'Rua deveria ser válida.');

        $morada->localidade = 'Localidade de Teste';
        $this->assertTrue($morada->validate(['localidade']), 'Localidade deveria ser válida.');

        $morada->codpostal = '1234-567';
        $this->assertTrue($morada->validate(['codpostal']), 'Código Postal deveria ser válido.');

        $morada->user_id = $user->id;
        $this->assertTrue($morada->validate(['user_id']), 'User_id deveria ser válido.');

    }


    public function testCreateMoradaSucessfully()
    {
        $user = $this->tester->grabFixture('users', 'user1');
        $model = new Morada();

        $model->rua = 'Rua de Teste';
        $model->localidade = 'Localidade de Teste';
        $model->codpostal = '1234-567';
        $model->user_id = $user->id;

        $this->assertTrue($model->validate(), 'Morada deveria ser válida.');

        $this->assertTrue($model->save(), 'Erro ao guardar a Morada.');

        $this->assertEquals('Rua de Teste', Morada::findOne(['id' => $model->id])->rua);
    }

    public function testUpdateMoradaSuccessfully()
    {
        $user = $this->tester->grabFixture('users', 'user1');
        $morada = $this->tester->grabFixture('moradas', 'morada1');

        $morada->rua = 'Nova Rua';
        $morada->localidade = 'Nova Localidade';
        $morada->codpostal = '1234-567';
        $morada->user_id = $user->id;

        $this->assertTrue($morada->validate(), 'Morada deveria ser válida.');

        $this->assertTrue($morada->save(), 'Erro ao guardar a Morada.');

        $this->assertEquals('Nova Rua', Morada::findOne(['id' => $morada->id])->rua);
    }

    public function testDeleteMoradaSuccessfully()
    {
        $morada = $this->tester->grabFixture('moradas', 'morada1');

        $this->assertGreaterThan(0, $morada->delete(), 'Erro ao apagar a Morada.');

        $this->assertNull(Morada::findOne(['id' => $morada->id]), 'A morada não deveria mais existir na base de dados.');
    }
}
