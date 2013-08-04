<?php

use Mockery as m;
use Way\Tests\Factory;

class PortfolioTest extends TestCase {

	public function __construct()
	{
        $this->mock = m::mock('Eloquent', 'Portfolio');
        $this->collection = m::mock('Illuminate\Database\Eloquent\Collection')->shouldDeferMissing();
	}

    public function setUp()
    {
        // $this->attributes = Factory::asset(['id' => 1]);
        // $this->app->instance('Portfolio', $this->mock);
    }

	public function testPortfolioAttributesExist()
	{
		$this->mock->url = 'nadaaa.com';
		$this->assertEquals('nadaaa.com', $this->mock->url);
	}


}