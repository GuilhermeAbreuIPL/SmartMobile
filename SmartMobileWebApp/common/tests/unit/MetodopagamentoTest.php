<?php

namespace common\tests\unit;

use common\fixtures\MetodoPagamentoFixture;
use common\models\MetodoPagamento;
use common\tests\UnitTester;

class MetodopagamentoTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    public function _fixtures()
    {
        return [
            'metodos' => [
                'class' => MetodoPagamentoFixture::class,
                'dataFile' => codecept_data_dir() . 'metodopagamento.php'
            ]
        ];
    }

    public function testValidationWithInvalidData()
    {
        $model = new MetodoPagamento();

        // Teste com dados inválidos

        $model->nome = str_repeat('a', 46);
        $this->assertFalse($model->validate(['nome']), 'Nome não deveria ter mais de 45 caracteres.');

        // Teste com dados required

        $model->nome = null;
        $this->assertFalse($model->validate(['nome']), 'Nome é obrigatório.');

        $model->descricao = null;
        $this->assertFalse($model->validate(['descricao']), 'Descrição é obrigatória.');

        //teste com dados de tipo errado

        $model->nome = 123;
        $this->assertFalse($model->validate(['nome']), 'Nome não deveria ser um número.');

        $model->descricao = 123;
        $this->assertFalse($model->validate(['descricao']), 'Descrição não deveria ser um número.');

    }

    public function testValidationWithValidData()
    {
        $model = new MetodoPagamento();

        // Teste com dados válidos

        $model->nome = 'Cartão de Crédito';
        $this->assertTrue($model->validate(['nome']), 'Nome deveria ser válido.');

        $model->descricao = 'Pagamento com cartão de crédito.';
        $this->assertTrue($model->validate(['descricao']), 'Descrição deveria ser válida.');
    }

    public function testCreateMetodoPagamentoSuccessfully()
    {
        $model = new MetodoPagamento();
        $model->nome = 'Cartão de Crédito';
        $model->descricao = 'Pagamento utilizando cartão de crédito.';

        $this->assertTrue($model->validate(), 'Erro ao validar o modelo.');

        $this->assertTrue($model->save(), 'Erro ao salvar o modelo.');

        $this->assertEquals('Cartão de Crédito', MetodoPagamento::findOne(['id' => $model->id])->nome);
    }

    public function testUpdateMetodoPagamentoSuccessfully()
    {
        $metodo = $this->tester->grabFixture('metodos', 'metodo1');
        $metodo->nome = 'Transferência Bancária';
        $metodo->descricao = 'Pagamento via transferência bancária.';

        $this->assertTrue($metodo->validate(), 'Erro ao validar o modelo.');

        $this->assertTrue($metodo->save(), 'Erro ao salvar o modelo.');
        $this->assertEquals('Transferência Bancária', MetodoPagamento::findOne(['id' => $metodo->id])->nome);
    }

    public function testDeleteMetodoPagamentoSuccessfully()
    {
        $metodo = $this->tester->grabFixture('metodos', 'metodo1');

        $this->assertGreaterThan(0, $metodo->delete(), 'Erro ao apagar o Metodo de Pagamento.');

        $this->assertNull(MetodoPagamento::findOne(['id' => $metodo->id]), 'O método de pagamento não deveria mais existir na base de dados.');
    }
}
