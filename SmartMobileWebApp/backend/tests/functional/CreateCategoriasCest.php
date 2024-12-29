<?php


namespace backend\tests\Functional;

use backend\tests\FunctionalTester;
use common\models\Categoria;

class CreateCategoriasCest
{
    public function _before(FunctionalTester $I)
    {
        // login
        $I->amOnPage('/site/login');
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->fillField('input[name="LoginForm[password]"]', '12345678');
        $I->click('login-button');
    }

    // tests
    public function createCategoriasWithFunctionalData(FunctionalTester $I)
    {
        $I->amOnPage('categoria/create?categoriaprincipalid=0');
        $I->fillField('Categoria[nome]', 'Categoria de teste');
        $I->click('submit-button');

        $I->see('Categoria de teste');
        $I->seeRecord(Categoria::class, ['nome' => 'Categoria de teste']);

    }

    public function createCategoriasWithInvalidData1(FunctionalTester $I)
    {
        $I->amOnPage('categoria/create?categoriaprincipalid=0');
        $I->fillField('Categoria[nome]', '');
        $I->click('submit-button');

        $I->see('Nome cannot be blank.');
    }

    public function createCategoriasWithInvalidData2(FunctionalTester $I)
    {
        $I->amOnPage('categoria/create?categoriaprincipalid=0');
        $I->fillField('Categoria[nome]', str_repeat('a', 46));
        $I->click('submit-button');

        $I->see('Nome should contain at most 45 characters.');
    }
}
