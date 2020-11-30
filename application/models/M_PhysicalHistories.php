<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_PhysicalHistories extends Eloquent
{
	protected $table		= 'physical_histories';
	protected $primaryKey	= 'id';

	public function project_item()
	{
		require_once __DIR__ . '/M_PhysicalHistories.php';
		return $this->hasOne('M_PhysicalHistories', 'id', 'item_id');
	}
}