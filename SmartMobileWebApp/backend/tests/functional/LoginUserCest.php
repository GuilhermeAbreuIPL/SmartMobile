<?php


namespace backend\tests\Functional;

use backend\tests\FunctionalTester;

class LoginUserCest
{
    public function _before(FunctionalTester $I)
    {
    }


    public function TestLoginWithFunctionalData(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->fillField('input[name="LoginForm[password]"]', '12345678');
        $I->click('login-button');

        $I->dontSee('Incorrect username or password.');
        $I->dontSee('Login');
        $I->see('Smart Mobile Dashboard');
    }

    public function TestLoginWithInvalidData(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $I->fillField('input[name="LoginForm[username]"]', 'adminaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        $I->fillField('input[name="LoginForm[password]"]', '123456789101112131415161718192021222324252627282930313233343536373839404142434445464748495051525354555657585960');
        $I->click('login-button');

        $I->see('Incorrect username or password.');
        $I->see('Login');
        $I->dontSee('Smart Mobile Dashboard');
    }
}
