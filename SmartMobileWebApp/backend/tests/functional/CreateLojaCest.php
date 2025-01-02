<?php


namespace backend\tests\Functional;

use backend\tests\FunctionalTester;

class CreateLojaCest
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
    public function CreateLojaWithValidData(FunctionalTester $I)
    {
        $I->amOnPage('/loja/create');
        $I->fillField('input[name="Loja[nome]"]', 'Loja Teste');
        $I->fillField('input[name="Loja[contacto]"]', '12345678');
        $I->fillField('input[name="Loja[rua]"]', 'Endereço da Loja Teste');
        $I->fillField('input[name="Loja[localidade]"]', 'Localidade da Loja Teste');
        $I->fillField('input[name="Loja[codpostal]"]', '1234-567');
        $I->click('submit-button');

        $I->seeRecord('common\models\Loja', [
            'nome' => 'Loja Teste',
            'contacto' => '12345678',
            'rua' => 'Endereço da Loja Teste',
            'localidade' => 'Localidade da Loja Teste',
            'codpostal' => '1234-567',
        ]);

        $I->see('Loja Teste');
        $I->see('12345678');
        $I->see('Endereço da Loja Teste');
        $I->see('Localidade da Loja Teste');
        $I->see('1234-567');
    }

    public function CreateLojaWithInvalidData(FunctionalTester $I)
    {
        $I->amOnPage('/loja/create');
        $I->fillField('input[name="Loja[nome]"]', '');
        $I->fillField('input[name="Loja[contacto]"]', '12345678');
        $I->fillField('input[name="Loja[rua]"]', 'Endereço da Loja Teste');
        $I->fillField('input[name="Loja[localidade]"]', 'Localidade da Loja Teste');
        $I->fillField('input[name="Loja[codpostal]"]', '1234-5678');
        $I->click('submit-button');

        $I->see('Nome cannot be blank.');
        $I->see('Codpostal should contain at most 8 characters.');
    }
}
