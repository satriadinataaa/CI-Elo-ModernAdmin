<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_Accounts extends Eloquent
{
	protected $table		= 'accounts';
	protected $primaryKey	= 'id';

	public function projects()
	{
		require_once __DIR__ . '/M_Projects.php';
		return $this->hasMany('M_Projects', 'project_id', 'id');
	}

	public function role()
	{
		require_once __DIR__ . '/M_Roles.php';
		return $this->hasOne('M_Roles', 'id', 'role_id');
	}	
}