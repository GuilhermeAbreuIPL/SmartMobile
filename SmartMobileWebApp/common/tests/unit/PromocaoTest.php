<?php


namespace common\tests\unit;

use common\fixtures\PromocaoFixture;
use common\tests\UnitTester;
use common\models\Promocao;

class PromocaoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    public function _fixtures()
    {
        return [
            'promocoes' => [
                'class' => PromocaoFixture::class,
                'dataFile' => codecept_data_dir() . 'promocao.php'
            ]
        ];
    }

    public function testValidationWithInvalidData()
    {
        $promocao = new Promocao();

        // Teste com dados inválidos

        $promocao->nome = str_repeat('a', 101);
        $this->assertFalse($promocao->validate(['nome']), 'Nome não deveria ter mais de 100 caracteres.');

        $promocao->descontopercentual = 101;
        $this->assertFalse($promocao->validate(['descontopercentual']), 'Desconto percentual não deveria ser maior que 100.');

        // Teste com dados required

        $promocao->nome = null;
        $this->assertFalse($promocao->validate(['nome']), 'Nome é obrigatório.');

        $promocao->descricao = null;
        $this->assertFalse($promocao->validate(['descricao']), 'Descrição é obrigatória.');

        $promocao->descontopercentual = null;
        $this->assertFalse($promocao->validate(['descontopercentual']), 'Desconto percentual é obrigatório.');

        // Teste com dados de tipo errado

        $promocao->nome = 123;
        $this->assertFalse($promocao->validate(['nome']), 'Nome não deveria ser um número.');

        $promocao->descricao = 123;
        $this->assertFalse($promocao->validate(['descricao']), 'Descrição não deveria ser um número.');

        $promocao->descontopercentual = 'string';
        $this->assertFalse($promocao->validate(['descontopercentual']), 'Desconto percentual não deveria ser uma string.');
    }

    public function testValidationWithValidData()
    {
        $promocao = new Promocao();

        $promocao->nome = 'Promoção Teste';
        $this->assertTrue($promocao->validate(['nome']), 'Nome da promoção deveria ser válido.');

        $promocao->descricao = 'Descrição da promoção de teste';
        $this->assertTrue($promocao->validate(['descricao']), 'Descrição da promoção deveria ser válida.');

        $promocao->descontopercentual = 20.5;
        $this->assertTrue($promocao->validate(['descontopercentual']), 'Desconto percentual deveria ser válido.');
    }

    public function testCreatePromocaoSuccessfully()
    {
        $model = new Promocao();
        $model->nome = 'Promoção Teste';
        $model->descricao = 'Descrição da promoção de teste';
        $model->descontopercentual = 20.5;

        $this->assertTrue($model->validate(), 'Modelo deveria ser válido.');

        $this->assertTrue($model->save(), 'Erro ao guardar a promoção.');

        $this->assertEquals('Promoção Teste', Promocao::findOne($model->id)->nome);
    }

    public function testUpdatePromocaoSuccessfully()
    {
        $model = $this->tester->grabFixture('promocoes', 'promocao1');
        $model->nome = 'Promoção Teste Atualizada';
        $model->descricao = 'Descrição da promoção de teste atualizada';
        $model->descontopercentual = 32;

        $this->assertTrue($model->validate(), 'Modelo deveria ser válido.');

        $this->assertTrue($model->save(), 'Erro ao guardar a promoção.');

        $this->assertEquals('Promoção Teste Atualizada', Promocao::findOne($model->id)->nome);
    }

    public function testDeletePromocaoSuccessfully()
    {
        $promocao = $this->tester->grabFixture('promocoes', 'promocao1');

        $this->assertGreaterThan(0, $promocao->delete(), 'Erro ao apagar a promoção.');

        $this->assertNull(Promocao::findOne($promocao->id), 'A promoção não deveria existir na base de dados.');
    }

}
