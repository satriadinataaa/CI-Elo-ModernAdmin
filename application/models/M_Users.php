<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_Users extends Eloquent
{
	protected $table		= 'users';
    protected $primaryKey	= 'id_user';
    
    public function cabang(){
        require_once __DIR__ . '/M_Cabang.php';
		return $this->hasOne('M_Cabang', 'id_cabang', 'id_cabang');
    }
     public function penjualan(){
        require_once __DIR__ . '/M_Penjualan.php';
		return $this->hasOne('M_Penjualan', 'id_user', 'id_user');
    }
    public function role(){
        require_once __DIR__ . '/M_Roles.php';
		return $this->hasOne('M_Roles', 'id_role', 'id_role');
    }

}