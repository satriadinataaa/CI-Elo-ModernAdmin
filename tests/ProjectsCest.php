<?php 
// vendor/bin/codecept run acceptance ProjectsCest --steps

require 'vendor/autoload.php';

class ProjectsCest
{
	private $faker;

    public function _before(AcceptanceTester $I)
    {
    	$this->faker = Faker\Factory::create();
    }

    public function addNewProgram(AcceptanceTester $I)
    {
    	$I->amOnPage('/home/add-project');
    	$I->see('Input Program');

    	$I->selectOption('type_id', 2);
    	$I->fillField('project_name', $this->faker->catchPhrase);
    	$I->fillField('contract_value', $this->faker->numberBetween(1000000, 100000000));
    	$I->fillField('financial_budget_ceiling', $this->faker->numberBetween(1000000, 100000000));
    	$I->fillField('contract_number', $this->faker->swiftBicNumber());
    	$I->fillField('contract_date', $this->faker->date());
    	$I->selectOption('provider_id', 4);

    	$I->click(['id' => 'add-item-button']);
    	$I->click(['id' => 'add-item-button']);

    	$I->fillField(['id' => 'item_name_1'], $this->faker->catchPhrase);
    	$I->fillField(['id' => 'item_budget_ceiling_1'], $this->faker->numberBetween(1000000, 100000000));

    	$I->fillField(['id' => 'item_name_2'], $this->faker->catchPhrase);
    	$I->fillField(['id' => 'item_budget_ceiling_2'], $this->faker->numberBetween(1000000, 100000000));

    	$I->fillField(['id' => 'item_name_3'], $this->faker->catchPhrase);
    	$I->fillField(['id' => 'item_budget_ceiling_3'], $this->faker->numberBetween(1000000, 100000000));

    	$I->click('submit');

    	$I->makeScreenshot();
    	$I->see('Create new program success');
    }
}
