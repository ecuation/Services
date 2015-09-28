<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
    //     Model::unguard();

    //     // $this->call(UserTableSeeder::class);

    //     Model::reguard();
    // }
    public function run()
    {
        /*for ($i=1; $i <6 ; $i++) { 
            
            DB::table('users')->insert([
                'name' => 'user_'.$i,
                'email' => 'user_'.$i.'@gmail.com',
                'password' => Hash::make('secret')
            ]);
        }

        for ($i=1; $i < 4; $i++) { 
            DB::table('customers')->insert([
                'company' => 'company_'.$i
            ]);
        }*/
		$this->call(UserTableSeeder::class);
        
    }    
}
