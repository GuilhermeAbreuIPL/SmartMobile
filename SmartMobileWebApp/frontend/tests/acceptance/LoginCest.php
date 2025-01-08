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
        $I->wait(1.5);
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->wait(1.5);
        $I->fillField('input[name="LoginForm[password]"]', '12345678');
        $I->wait(1.5);
        $I->click('#login-button');
        $I->wait(1.5);

        //index
        $I->scrollTo('#content-7');
        $I->wait(1.5);
        $I->moveMouseOver('#content-7');
        $I->wait(1.5);
        $I->click('#cart-btn-7');
        $I->wait(1.5);

        //procurar produto
        $I->fillField('input[name="search"]', 'cao1');
        $I->wait(1.5);
        $I->pressKey('input[name="search"]', \Facebook\WebDriver\WebDriverKeys::ENTER);
        $I->wait(1.5);
        $I->moveMouseOver('#Product-Box-9');
        $I->wait(1.5);
        $I->click('#cart-btn-9');

        //carrinho
        $I->click('#addquantity-7');
        $I->wait(1.5);
        $I->click('#removequantity-7');
        $I->wait(1.5);
        $I->click('#addquantity-7');
        $I->wait(1.5);
        $I->click('#removequantity-9');
        $I->wait(1.5);
        $I->click('#checkout-btn');
        $I->wait(1.5);

        //checkout
        $I->click('#loja-btn');
        $I->wait(1.5);
        $I->click('#morada-btn');
        $I->wait(1.5);
        $I->click('#btn-morada-user-1');
        $I->wait(1.5);
        $I->click('#btn-Visa');
        $I->wait(1.5);
        $I->click('.btn-finalizar');
        $I->wait(1.5);

        //vai buscar o id da ultima compra feita atraves do url
        $id = $I->grabFromCurrentUrl('/id=(\d+)/');
        $I->wait(1.5);

        //faturas
        $I->click('#btn-voltar');
        $I->wait(1.5);
        $I->click('#view-details-' . $id);
        $I->wait(1.5);
        $I->click('#profile-button');
        $I->wait(1.5);
        $I->click('.btn-logout');
        $I->wait(1.5);

    }
}
