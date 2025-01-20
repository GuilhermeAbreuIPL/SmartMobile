<?php


namespace frontend\tests\Acceptance;

use frontend\tests\AcceptanceTester;

class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/SmartMobile/SmartMobileWebApp/frontend/web/site/login');
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        //login
        $I->waitForElement('input[name="LoginForm[username]"]', 5);
        $I->wait(2);
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->wait(2);
        $I->fillField('input[name="LoginForm[password]"]', '12345678');
        $I->wait(2);
        $I->click('#login-button');
        $I->wait(2);

        //index
        $I->scrollTo('#content-7');
        $I->wait(2);
        $I->moveMouseOver('#content-7');
        $I->wait(2);
        $I->click('#cart-btn-7');
        $I->wait(2);

        //procurar produto
        $I->fillField('input[name="search"]', 'Iphone');
        $I->wait(2);
        $I->pressKey('input[name="search"]', \Facebook\WebDriver\WebDriverKeys::ENTER);
        $I->wait(2);
        $I->moveMouseOver('#Product-Box-9');
        $I->wait(2);
        $I->click('#cart-btn-9');

        //carrinho
        $I->click('#addquantity-7');
        $I->wait(2);
        $I->click('#removequantity-7');
        $I->wait(2);
        $I->click('#addquantity-7');
        $I->wait(2);
        $I->click('#removequantity-9');
        $I->wait(2);
        $I->click('#checkout-btn');
        $I->wait(2);

        //checkout
        $I->click('#loja-btn');
        $I->wait(2);
        $I->click('#morada-btn');
        $I->wait(2);
        $I->click('#btn-morada-user-1');
        $I->wait(2);
        $I->click('#btn-Visa');
        $I->wait(2);
        $I->click('.btn-finalizar');
        $I->wait(2);

        //vai buscar o id da ultima compra feita atraves do url
        $id = $I->grabFromCurrentUrl('/id=(\d+)/');
        $I->wait(2);

        //faturas
        $I->click('#btn-voltar');
        $I->wait(2);
        $I->click('#view-details-' . $id);
        $I->wait(2);
        $I->click('#profile-button');
        $I->wait(2);
        $I->click('.btn-logout');
        $I->wait(2);
        $I->click('#profile-button');

    }
}
