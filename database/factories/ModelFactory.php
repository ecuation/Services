<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
	    'is_active' => 1,
	    'confirmed' => 1,
	    'verification_key' => str_random(20)
    ];
});

$factory->define(App\UserRoles::class, function () {
	return [
		'role' => 'Admin'
	];
});
