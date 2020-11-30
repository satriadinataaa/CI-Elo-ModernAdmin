<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_Cabang extends Eloquent
{
	protected $table		= 'cabang';
    protected $primaryKey	= 'id_cabang';
    
    public function obat(){
        require_once __DIR__ . '/M_Obat.php';
		return $this->hasMany('M_Obat', 'id_cabang', 'id_cabang');
    }
    
    public function user(){
        require_once __DIR__ . '/M_Users.php';
		return $this->hasMany('M_Users', 'id_cabang', 'id_cabang');
    }
    public function penjualan(){
        require_once __DIR__ . '/M_Penjualan.php';
		return $this->hasMany('M_Penjualan', 'id_cabang', 'id_cabang');
    }

}