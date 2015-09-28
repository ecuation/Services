<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    factory(App\User::class, 5)->create()->each(function($u){
			$u->roles()->save(factory(App\UserRoles::class)->make());
	    });
    }
}
