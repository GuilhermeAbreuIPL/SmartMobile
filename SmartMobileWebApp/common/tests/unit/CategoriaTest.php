<?php


namespace common\tests\Unit;

use common\tests\UnitTester;
use common\models\Categoria;

class CategoriaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testCreateCategoriaWithValidData()
    {
        $categoria = new Categoria([
            'nome' => 'Eletrônicos',
        ]);

        $this->assertTrue($categoria->validate(), 'A categoria com dados válidos deveria ser validada.');
    }

    public function testCreateCategoriaWithInvalidData()
    {
        $categoria = new Categoria([
            'nome' => str_repeat('a', 46), // Excede o limite de 45 caracteres
            'categoria_principal_id' => 'invalid_id', // Tipo inválido
        ]);

        $this->assertFalse($categoria->validate(), 'A categoria com dados inválidos não deveria ser validada.');
        $this->assertArrayHasKey('nome', $categoria->errors, 'Deveria ter erro para o campo "nome".');
        $this->assertArrayHasKey('categoria_principal_id', $categoria->errors, 'Deveria ter erro para o campo "categoria_principal_id".');
    }

    public function testCreateCategoriaWithMinimalData()
    {
        $categoria = new Categoria([
            'nome' => 'Roupas',
        ]);

        $this->assertTrue($categoria->validate(), 'A categoria deveria ser válida com apenas o campo opcional "nome".');
    }

    public function testRelationshipWithCategoriaPrincipal()
    {
        $categoriaPrincipal = new Categoria([
            'nome' => 'Eletrodomésticos',
        ]);
        $categoriaPrincipal->save(false);

        $categoriaFilha = new Categoria([
            'nome' => 'Refrigeradores',
            'categoria_principal_id' => $categoriaPrincipal->id,
        ]);
        $categoriaFilha->save(false);

        $this->assertEquals($categoriaPrincipal->id, $categoriaFilha->categoria_principal_id, 'A categoria filha deveria estar associada à categoria principal.');
    }
}
