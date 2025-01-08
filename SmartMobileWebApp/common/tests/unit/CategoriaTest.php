<?php

namespace common\tests\unit;

use common\fixtures\CategoriaFixture;
use common\models\Categoria;
use common\tests\UnitTester;

class CategoriaTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    public function _fixtures()
    {
        return [
            'categorias' => [
                'class' => CategoriaFixture::class,
                'dataFile' => codecept_data_dir() . 'categorias.php'
            ]
        ];
    }

    public function testValidationWithInvalidData()
    {
        $model = new Categoria();

        // Teste com dados inválidos

        $model->nome = str_repeat('a', 46);
        $this->assertFalse($model->validate(['nome']), 'Nome não deveria ter mais de 45 caracteres.');


        // Teste com dados required

        $model->nome = null;
        $this->assertFalse($model->validate(['nome']), 'Nome é obrigatório.');

        //teste com dados de tipo errado

        $model->nome = 123;
        $this->assertFalse($model->validate(['nome']), 'Nome não deveria ser um número.');

        $model->categoria_principal_id = 'string';
        $this->assertFalse($model->validate(['categoria_principal_id']), 'Categoria Principal não deveria ser uma string.');

    }

    public function testValidationWithValidData()
    {
        $model = new Categoria();

        // Teste com dados válidos

        $model->nome = 'Eletrônicos';
        $this->assertTrue($model->validate(['nome']), 'Nome deveria ser válido.');

        $model->categoria_principal_id = null;
        $this->assertTrue($model->validate(['categoria_principal_id']), 'Categoria Principal deveria ser válida.');
    }

    public function testCreateCategoriaSuccessfully()
    {
        $model = new Categoria();

        $model->nome = 'Eletrônicos';
        $model->categoria_principal_id = null;

        $this->assertTrue($model->validate(), 'Erro ao validar o modelo.');

        $this->assertTrue($model->save(), 'Erro ao salvar o modelo.');

        $this->assertEquals('Eletrônicos', Categoria::findOne(['id' => $model->id])->nome);
    }

    public function testUpdateCategoriaSuccessfully()
    {
        $categoria = $this->tester->grabFixture('categorias', 'categoria1');
        $categoria->nome = 'Novo Nome';
        $categoria->categoria_principal_id = null;

        $this->assertTrue($categoria->validate(), 'Erro ao validar o modelo.');

        $this->assertTrue($categoria->save(), 'Erro ao salvar o modelo.');

        $this->assertEquals('Novo Nome', Categoria::findOne(['id' => $categoria->id])->nome);
    }

    public function testDeleteCategoriaSuccessfully()
    {
        $categoria = $this->tester->grabFixture('categorias', 'categoria1');

        Categoria::deleteAll(['categoria_principal_id' => $categoria->id]);

        $this->assertGreaterThan(0, $categoria->delete(), 'Erro ao apagar a Categoria.');

        $this->assertNull(Categoria::findOne(['id' => $categoria->id]), 'A categoria não deveria mais existir na base de dados.');
    }
}
