<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_Obat extends Eloquent
{
	protected $table		= 'obat';
    protected $primaryKey	= 'id_obat';
    
    public function cabang(){
        require_once __DIR__ . '/M_Cabang.php';
		return $this->hasOne('M_Cabang', 'id_cabang', 'id_cabang');
    }
    public function barangjual(){
        require_once __DIR__ . '/M_BarangJual.php';
		return $this->hasMany('M_BarangJual', 'id_obat', 'id_obat');
    }

}