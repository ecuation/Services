<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Language extends Facade
{
	protected static function getFacadeAccessor() { return 'App\Contracts\Translatable'; }
}