<?php


namespace backend\tests\functional;

use backend\tests\FunctionalTester;

class CreatePromocaoCest
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
    public function createpromocaoWithValidData(FunctionalTester $I)
    {
        $I->amOnPage('/promocao/create');
        $I->fillField('Promocao[nome]', 'Promoção de teste');
        $I->fillField('Promocao[descricao]', 'Descrição da promoção de teste');
        $I->fillField('Promocao[descontopercentual]', '10');
        $I->click('submit-button');

        $I->see('Promoção de teste');
        $I->see('Descrição da promoção de teste');
        $I->see('10');
    }

    public function createpromocaoWithInvalidData(FunctionalTester $I)
    {
        $I->amOnPage('/promocao/create');
        $I->fillField('Promocao[nome]', str_repeat('a', 101));
        $I->fillField('Promocao[descricao]', '');
        $I->fillField('Promocao[descontopercentual]', 'a');
        $I->click('submit-button');

        $I->see('Nome should contain at most 100 characters.');
        $I->see('Descricao cannot be blank.');
        $I->see('Descontopercentual must be a number.');
    }
}
