<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_ProjectItem extends Eloquent
{
	protected $table		= 'project_item';
	protected $primaryKey	= 'id';

	public function project()
	{
		require_once __DIR__ . '/M_Projects.php';
		return $this->hasOne('M_Projects', 'project_id', 'id');
	}

	public function physical_histories()
	{
		require_once __DIR__ . '/M_PhysicalHistories.php';
		return $this->hasMany('M_PhysicalHistories', 'item_id', 'id');
	}

	public function financial_histories()
	{
		require_once __DIR__ . '/M_FinancialHistories.php';
		return $this->hasMany('M_FinancialHistories', 'item_id', 'id');
	}
}