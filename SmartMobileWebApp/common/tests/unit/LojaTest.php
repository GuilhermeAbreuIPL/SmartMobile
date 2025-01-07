<?php

namespace common\tests\unit;

use common\fixtures\LojaFixture;
use common\models\Loja;
use common\tests\UnitTester;

class LojaTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    public function _fixtures()
    {
        return [
            'lojas' => [
                'class' => LojaFixture::class,
                'dataFile' => codecept_data_dir() . 'loja.php'
            ]
        ];
    }

    public function testValidationWithInvalidData()
    {
        $model = new Loja();

        // Teste com dados inválidos

        $model->nome = str_repeat('a', 46);
        $this->assertFalse($model->validate(['nome']), 'Nome não deveria ter mais de 45 caracteres.');

        $model->contacto = '123';
        $this->assertFalse($model->validate(['contacto']), 'Contacto não deveria ter menos de 9 caracteres.');

        $model->rua = str_repeat('a', 86);
        $this->assertFalse($model->validate(['rua']), 'Rua não deveria ter mais de 85 caracteres.');

        $model->codpostal = '123456789';
        $this->assertFalse($model->validate(['codpostal']), 'Código Postal não deveria ter mais de 8 caracteres.');

        $model->localidade = str_repeat('a', 46);
        $this->assertFalse($model->validate(['localidade']), 'Localidade não deveria ter mais de 45 caracteres.');

        //Teste com dados required

        $model->nome = null;
        $this->assertFalse($model->validate(['nome']), 'Nome é obrigatório.');

        $model->contacto = null;
        $this->assertFalse($model->validate(['contacto']), 'Contacto é obrigatório.');

        $model->rua = null;
        $this->assertFalse($model->validate(['rua']), 'Rua é obrigatória.');

        $model->codpostal = null;
        $this->assertFalse($model->validate(['codpostal']), 'Código Postal é obrigatório.');

        $model->localidade = null;
        $this->assertFalse($model->validate(['localidade']), 'Localidade é obrigatória.');

        //Teste com dados de tipo errado

        $model->nome= 2;
        $this->assertFalse($model->validate(['nome']), 'Nome não deveria ser um número.');

        $model->contacto = 2;
        $this->assertFalse($model->validate(['contacto']), 'Contacto não deveria ser um número.');

        $model->rua = 2;
        $this->assertFalse($model->validate(['rua']), 'Rua não deveria ser um número.');

        $model->codpostal = 2;
        $this->assertFalse($model->validate(['codpostal']), 'Código Postal não deveria ser um número.');

        $model->localidade = 2;
        $this->assertFalse($model->validate(['localidade']), 'Localidade não deveria ser um número.');
    }

    public function testValidationWithValidData()
    {
        $model = new Loja();

        $model->nome = 'Loja Teste';
        $this->assertTrue($model->validate(['nome']), 'Nome deveria ser válido.');

        $model->contacto = '912345678';
        $this->assertTrue($model->validate(['contacto']), 'Contacto deveria ser válido.');

        $model->rua = 'Rua de Teste';
        $this->assertTrue($model->validate(['rua']), 'Rua deveria ser válida.');

        $model->codpostal = '2400-400';
        $this->assertTrue($model->validate(['codpostal']), 'Código Postal deveria ser válido.');

        $model->localidade = 'Localidade';
        $this->assertTrue($model->validate(['localidade']), 'Localidade deveria ser válida.');
    }

    public function testCreateLojaSuccessfully()
    {
        $model = new Loja();
        $model->nome = 'Loja Exemplo';
        $model->contacto = '912345678';
        $model->rua = 'Rua Exemplo, 123';
        $model->localidade = 'Cidade Exemplo';
        $model->codpostal = '1234-567';

        $this->assertTrue($model->validate(), 'Erro ao validar o modelo.');

        $this->assertTrue($model->save(), 'Erro ao salvar o modelo.');

        $this->assertEquals('Loja Exemplo', Loja::findOne(['id' => $model->id])->nome);
    }

    public function testUpdateLojaSuccessfully()
    {
        $loja = $this->tester->grabFixture('lojas', 'loja1');
        $loja->nome = 'Novo Nome da Loja';
        $loja->contacto = '987654321';
        $loja->rua = 'Nova Rua, 456';
        $loja->localidade = 'Nova Cidade';
        $loja->codpostal = '2345-678';

        $this->assertTrue($loja->validate(), 'Erro ao validar o modelo.');

        $this->assertTrue($loja->save(), 'Erro ao salvar o modelo.');

        $this->assertEquals('Novo Nome da Loja', Loja::findOne(['id' => $loja->id])->nome);
    }

    public function testDeleteLojaSuccessfully()
    {
        $loja = $this->tester->grabFixture('lojas', 'loja1');

        $this->assertGreaterThan(0, $loja->delete(), 'Erro ao Apagar a Loja.');

        $this->assertNull(Loja::findOne(['id' => $loja->id]), 'A loja não deveria existir na base de dados.');
    }
}
