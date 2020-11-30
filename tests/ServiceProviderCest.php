<?php 
// vendor/bin/codecept run acceptance ServiceProviderCest --steps

require 'vendor/autoload.php';

class ServiceProviderCest
{
	private $faker;
	private $email 		= '';
	private $username 	= '';

    public function _before(AcceptanceTester $I)
    {
    	$this->faker = Faker\Factory::create();
    }

    public function addNewServiceProvider(AcceptanceTester $I)
    {
    	$I->amOnPage('/home/add-vendor');
    	$I->see('Tambah Penyedia Jasa');

    	$this->email 	= $this->faker->email;
    	$this->username = $this->faker->username;

    	$I->fillField('name', $this->faker->name);
    	$I->fillField('email', $this->email);
    	$I->fillField('contact', $this->faker->phoneNumber);
    	$I->fillField('username', $this->username);
    	$I->fillField('password', '123456');
    	$I->fillField('rpassword', '123456');
    	$I->click('submit');

    	$I->makeScreenshot();
    	$I->see('Create new vendor success');
    }

    public function addNewServiceProviderDuplicateUsername(AcceptanceTester $I)
    {
    	$I->amOnPage('/home/add-vendor');
    	$I->see('Tambah Penyedia Jasa');

    	$I->fillField('name', $this->faker->name);
    	$I->fillField('email', $this->faker->email);
    	$I->fillField('contact', $this->faker->phoneNumber);
    	$I->fillField('username', $this->username);
    	$I->fillField('password', '123456');
    	$I->fillField('rpassword', '123456');
    	$I->click('submit');

    	$I->makeScreenshot();
    	$I->see('The username is already used');
    }

    public function addNewServiceProviderDuplicateEmail(AcceptanceTester $I)
    {
    	$I->amOnPage('/home/add-vendor');
    	$I->see('Tambah Penyedia Jasa');

    	$I->fillField('name', $this->faker->name);
    	$I->fillField('email', $this->email);
    	$I->fillField('contact', $this->faker->phoneNumber);
    	$I->fillField('username', $this->faker->userName);
    	$I->fillField('password', '123456');
    	$I->fillField('rpassword', '123456');
    	$I->click('submit');

    	$I->makeScreenshot();
    	$I->see('The email is already used');
    }

    public function addNewServiceProviderPasswordNotEqual(AcceptanceTester $I)
    {
    	$I->amOnPage('/home/add-vendor');
    	$I->see('Tambah Penyedia Jasa');

    	$I->fillField('name', $this->faker->name);
    	$I->fillField('email', $this->faker->email);
    	$I->fillField('contact', $this->faker->phoneNumber);
    	$I->fillField('username', $this->faker->userName);
    	$I->fillField('password', '1234567');
    	$I->fillField('rpassword', '123456');
    	$I->click('submit');

    	$I->makeScreenshot();
    	$I->see('Password must be equals to confirm password');
    }

    public function changePasswordWrongOldPassword(AcceptanceTester $I)
    {
    	$I->amOnPage('/home/add-vendor');
    	$I->see('Tambah Penyedia Jasa');

    	$I->click(['id' => 'toggle-change-password-' . $this->username]);

    	$I->fillField('c_old_password', '1234567');
    	$I->fillField('c_new_password', '123456');
    	$I->fillField('c_rpassword', '123456');
    	$I->click('change_password');

    	$I->makeScreenshot();
    	$I->see('Wrong old password');
    }

    public function changePasswordNotEqual(AcceptanceTester $I)
    {
    	$I->amOnPage('/home/add-vendor');
    	$I->see('Tambah Penyedia Jasa');

    	$I->click(['id' => 'toggle-change-password-' . $this->username]);

    	$I->fillField('c_old_password', '123456');
    	$I->fillField('c_new_password', '1234567');
    	$I->fillField('c_rpassword', '123456');
    	$I->click('change_password');

    	$I->makeScreenshot();
    	$I->see('Password must be equals to confirm password');
    }

    public function changePassword(AcceptanceTester $I)
    {
    	$I->amOnPage('/home/add-vendor');
    	$I->see('Tambah Penyedia Jasa');

    	$I->click(['id' => 'toggle-change-password-' . $this->username]);

    	$I->fillField('c_old_password', '123456');
    	$I->fillField('c_new_password', '123456');
    	$I->fillField('c_rpassword', '123456');
    	$I->click('change_password');

    	$I->makeScreenshot();
    	$I->see('Change password success');
    }
}
