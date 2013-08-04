<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// uncomment below to start with fresh tables
		// DB::table('users')->delete();
		// DB::table('roles')->delete();

		$this->call('UsersTableSeeder');
		$this->call('RolesTableSeeder');

		$user = User::where('username', '=', 'admin')->first();
		$admin = Role::where('name', '=', 'Admin')->first();

		$user->roles()->attach( $admin->id );
	}

}