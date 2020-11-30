<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class M_BarangJual extends Eloquent
{
	protected $table		= 'barang_jual';
    protected $primaryKey	= 'id';
    
    public function penjualan(){
        require_once __DIR__ . '/M_Penjualan.php';
		return $this->hasMany('M_Penjualan', 'id_penjualan', 'id_penjualan');
    }
    
    public function obat(){
        require_once __DIR__ . '/M_Obat.php';
		return $this->hasMany('M_Obat', 'id_obat', 'id_obat');
    }

}