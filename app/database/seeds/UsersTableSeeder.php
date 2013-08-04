<?php

class UsersTableSeeder extends Seeder {
	public function run()
	{
		User::create(array(
			'username' => 'admin', 
			'password' => 'password', 
			'password_confirmation' => 'password'
		));
	}
}
