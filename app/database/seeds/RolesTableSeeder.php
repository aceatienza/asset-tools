<?php

class RolesTableSeeder extends Seeder {
	public function run()
	{
		Role::create(array('name' => 'Admin'));
		Role::create(array('name' => 'User'));		
	}
}