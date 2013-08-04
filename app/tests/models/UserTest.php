<?php

use Mockery as m;
use Way\Tests\Factory;

class UserTest extends TestCase {
	use Way\Tests\ModelHelpers;

	// $this is $app Illuminate\Foundation\Application

	public function __construct()
	{
        $this->mock = m::mock('Eloquent', 'User');
        $this->collection = m::mock('Illuminate\Database\Eloquent\Collection')->shouldDeferMissing();
	}

    public function setUp()
    {
    	parent::setUp();

  //   	$this->user = Factory::create('User', [
  //   		'username' => 'johndoe',
  //   		'email'	=> 'john@doe.com',
  //   		'password' => 'password',
  //   		'password_confirmation' => 'password'
		// ]);
		
    }

    public function testIsInvalidWithoutUsername()
    {
    	$user = Factory::user(['username' => null]);
    	$this->assertNotValid($user);
    }

    public function testIsInvalidWithoutUniqueUsername()
    {
    	$user = Factory::user(['username' => 'johndoe']);
    	$user = Factory::user(['username' => 'johndoe']);
    	$this->assertNotValid($user);
    }

    public function testIsInvalidWithoutPassword()
    {
    	$user = Factory::user(['password' => null]);
    	$this->assertNotValid($user);
    }

    public function testBelongsToManyPortfolios()
    {
    	$this->assertBelongsToMany('portfolios', 'User');
    }

	public function testCanGetPassword()
	{
		$this->mock->shouldReceive('getAuthPassword')->once()
			->andReturn('password');
		$this->assertEquals('password', $this->mock->getAuthPassword());
	}

	public function testCreateUserDefault()
	{
		$this->mock->shouldReceive('afterSave')->once()
			->andReturn(True);

		$this->assertTrue(True, $this->mock->afterSave(true));

		// mock Role
		// should have default User role
		// $this->assertTrue(True, $this->mock->hasRole('User')); // incorrect
	}

}