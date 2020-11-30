<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_FinancialHistories extends Eloquent
{
	protected $table		= 'financial_histories';
	protected $primaryKey	= 'id';

	public function project_item()
	{
		require_once __DIR__ . '/M_ProjectItem.php';
		return $this->hasOne('M_ProjectItem', 'id', 'item_id');
	}
}