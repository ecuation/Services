<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table)
		{
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->boolean('is_active')->default(1);
            $table->boolean('confirmed')->default(0);
			$table->string('verification_key', 20)->unique();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('roles', function(Blueprint $table)
        {
        	$table->increments('id');
        	$table->string('role', 15);
	        $table->timestamps();
        });

        schema::create('user_roles', function(Blueprint $table)
        {
        	$table->integer('user_id')->unsigned()->index();

        	$table->foreign('user_id')
        		->references('id')->on('users')
        		->onDelete('cascade');

        	$table->integer('role_id')->unsigned()->index();

        	$table->foreign('role_id')
        		->references('id')->on('roles')
        		->onDelete('cascade');
        });

		Schema::create('companies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 80);
			$table->string('email')->unique();
			$table->string('api_key', 60);
			$table->string('verification_key', 20)->unique();
			$table->string('domain_url', 100);
			$table->boolean('is_active')->default(0);
			$table->boolean('confirmed')->default(0);
			$table->timestamps();
		});

		Schema::create('users_companies', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned()->index();

			$table->foreign('user_id')
				->references('id')->on('users')
				->onDelete('cascade');

			$table->integer('company_id')
				->unsigned()
				->index();

			$table->foreign('company_id')
				->references('id')->on('companies')
				->onDelete('cascade');

			$table->boolean('is_active');

			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('users_companies');
		Schema::dropIfExists('user_roles');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
		Schema::dropIfExists('companies');
    }
}
