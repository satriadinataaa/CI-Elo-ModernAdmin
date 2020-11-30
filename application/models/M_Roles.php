<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_Roles extends Eloquent
{
	protected $table		= 'role';
	protected $primaryKey	= 'id_role';

	public function user(){
        require_once __DIR__ . '/M_Users.php';
		return $this->hasOne('M_Users', 'id_role', 'id_role');
    }
}