<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $table = 'roles';

	protected $fillable = ['role'];

	public function users()
	{
		return $this->belongsTo('App\User');
	}
}
