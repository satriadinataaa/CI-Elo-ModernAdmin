<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_Penjualan extends Eloquent
{
	protected $table		= 'penjualan';
    protected $primaryKey	= 'id_penjualan';
    
    public function cabang(){
        require_once __DIR__ . '/M_Cabang.php';
		return $this->hasOne('M_Cabang', 'id_cabang', 'id_cabang');
    }

    public function user(){
        require_once __DIR__ . '/M_Users.php';
		return $this->hasMany('M_Users', 'id_user', 'id_user');
    }  
    
}