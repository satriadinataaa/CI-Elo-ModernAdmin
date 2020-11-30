<?php
class LoginCest 
{    
    public function _before(AcceptanceTester $I)
    {
        // $I->amOnPage('/');
    }

    public function loginSuccessfully(AcceptanceTester $I)
    {
        // write a positive login test 
        $I->amOnPage('/login');
        $I->see('Sistem');
        $I->wait(2);
        $I->fillField('username', 'azhry');
        $I->fillField('password', '4kuGanteng');
        $I->wait(2);
        $I->click('login');
        $I->see('Dashbjoard');
        $I->wait(2);
    }
    
    public function loginWithInvalidPassword(AcceptanceTester $I)
    {
        // write a negative login test
    }       
}