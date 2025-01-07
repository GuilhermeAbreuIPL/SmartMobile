<?php


namespace backend\tests\functional;

use backend\tests\FunctionalTester;

class CreateUserCest
{
    public function _before(FunctionalTester $I)
    {
        //login
        $I->amOnRoute('site/login');
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->fillField('input[name="LoginForm[password]"]', '12345678');
        $I->click('login-button');

    }

    public function TestCreateUserWithFunctionalData(FunctionalTester $I)
    {
        // criar usuario
        $I->amOnRoute('user/create');
        $I->see('Create User');
        $I->fillField('input[name="UserForm[username]"]', 'test');
        $I->fillField('input[name="UserForm[email]"]', 'test@gmail.com');
        $I->fillField('input[name="UserForm[password]"]', '12345678');
        $I->fillField('input[name="UserForm[nome]"]', 'Test User');
        $I->fillField('input[name="UserForm[nif]"]', '123456789');
        $I->fillField('input[name="UserForm[telemovel]"]', '123456789');
        $I->selectOption('UserForm[role]', 'Gestor');
        $I->click('Create User');

        // verificar se o usuario foi criado
        $I->see('Utilizador criado com sucesso!');
        $I->seeRecord('common\models\User', ['username' => 'test']);
    }

    public function TestCreateUserWithInvalidData(FunctionalTester $I)
    {
        // criar usuario
        $I->amOnRoute('user/create');
        $I->see('Create User');
        $I->fillField('input[name="UserForm[username]"]', 'test');
        $I->fillField('input[name="UserForm[email]"]', 'test@gmail.com');
        $I->fillField('input[name="UserForm[password]"]', '123456781111');
        $I->fillField('input[name="UserForm[nome]"]', '');
        $I->fillField('input[name="UserForm[nif]"]', '11111111111111111111111111');
        $I->fillField('input[name="UserForm[telemovel]"]', '123456789');
        $I->selectOption('UserForm[role]', 'Gestor');
        $I->click('Create User');

        // verificar se o usuario foi criado
        $I->see('Create User');
        $I->dontSeeRecord('common\models\User', ['username' => 'test']);
    }


    public function _after(FunctionalTester $I)
    {
        //logout
        $I->amOnRoute('site/logout');
    }
}
