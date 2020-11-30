<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_Projects extends Eloquent
{
	protected $table		= 'projects';
	protected $primaryKey	= 'id';

	public function items()
	{
		require_once __DIR__ . '/M_ProjectItem.php';
		return $this->hasMany('M_ProjectItem', 'project_id', 'id');
	}

	public function type()
	{
		require_once __DIR__ . '/M_ProjectType.php';
		return $this->hasOne('M_ProjectType', 'id', 'type_id');
	}

	public function provider()
	{
		require_once __DIR__ . '/M_Accounts.php';
		return $this->hasOne('M_Accounts', 'id', 'provider_id');
	}

	// public function options()
	// {
	// 	require_once(__DIR__ . '/Poll_option_m.php');
	// 	return $this->hasMany('Poll_option_m', 'poll_id', 'poll_id');
	// }

	// public function option_details()
	// {
	// 	require_once(__DIR__ . '/Poll_option_details_m.php');
	// 	return $this->hasMany('Poll_option_details_m', 'poll_id', 'poll_id');
	// }

	// public function votes()
	// {
	// 	require_once(__DIR__ . '/Vote_m.php');
	// 	return $this->hasMany('Vote_m', 'poll_id', 'poll_id');
	// }
}