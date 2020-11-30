<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_ProjectType extends Eloquent
{
	protected $table		= 'project_type';
	protected $primaryKey	= 'id';

	public function projects()
	{
		require_once __DIR__ . '/M_Projects.php';
		return $this->hasMany('M_Projects', 'type_id', 'id');
	}
}