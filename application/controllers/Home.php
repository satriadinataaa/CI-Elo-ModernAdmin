<?php  

class Home extends MY_Controller
{
	  public function __construct()
    {
     
      parent::__construct();
	  $this->load->model('M_Cabang');
	 
   
      $this->load->library('pdf');
      $this->module = 'home';
    }


    public function getMedicineNamebyCabang($cabang){
      $this->load->model('M_Obat');
      $obat = M_Obat::where('id_cabang','=',$cabang)->get();
      if(count($obat) > 0){
        foreach($obat as $o){
          $name[] = $o->nama;
         // echo json_encode($name);
        }
      }
      echo json_encode($name);
    }

   

    

    public function getMedicineIdbyCabang($cabang){
      $this->load->model('M_Obat');
      $obat = M_Obat::where('id_cabang','=',$cabang)->get();
      if(count($obat) > 0){
        foreach($obat as $o){
          $name[] = strval($o->id_obat);
         // echo json_encode($name);
        }
      }
      echo json_encode($name);
    }

    public function getObatbyId($cabang){
      $this->load->model('M_Obat');
      if($this->POST('id')){
        $obat = M_Obat::where('id_obat','=',$this->POST('id'))
                        ->where('id_cabang','=',$cabang)
                        ->first();
       
      }
      echo json_encode($obat);
    }

    public function getObatbyName($cabang){
      $this->load->model('M_Obat');
      if($this->POST('name')){
        $obat = M_Obat::where('nama','LIKE','%'.$this->POST('name').'%')
                        ->where('id_cabang','=',$cabang)
                        ->first();
       
      }
      echo json_encode($obat);
    }

    public function checkStock($cabang){
      $returntype=true;
      $askedStock = $this->POST('stok');
      $id = $this->POST('id');
      $this->load->model('M_Obat');
      $stockAvailable = $obat = M_Obat::where('id_obat','=',$id)
                          ->where('id_cabang','=',$cabang)
                          ->first();
      if($stockAvailable->stok >= $askedStock){
        $returntype=true;
      }
      else{
        $returntype=false;
      }
      echo json_encode($returntype);
    }
    public function index(){
        $this->load->model('M_Cabang');
        if($this->POST('submit')){
          
          $this->data['branchId'] = $this->POST('cabang');
         
          
       
          
          redirect('Home/beliObat/'.$this->data['branchId']);
        }
        $this->data['cabang'] = M_Cabang::OrderBy('created_at','desc')->get();
        $this->data['title'] 	= 'home';
        $this->data['content'] 	= 'cabang';
        $this->template($this->data, $this->module);
    }


    public function beliObat($cabang){
      
      $this->load->model('M_Cabang');
      $this->data['nama_cabang'] = M_Cabang::where('id_cabang',$cabang)->first();
      
      
          $refresh=false;
          
          if($this->POST('submit')){
              $this->load->model('M_Obat');
              $this->load->model('M_Penjualan');
              $this->load->model('M_BarangJual');
              $date = date('d-m-Y');
              $nama_pembeli = $this->POST('buyer_name');
              $no_hp = $this->POST('no_hp');
              $this->data['cabang'] = M_Cabang::where('nama_cabang',$this->POST('cabang'))->first();
              
              $itemCode = $this->POST('itemCode');
              $itemName = $this->POST('itemName');
              $satuan = $this->POST('satuan');
              $qty = $this->POST('qty');
              $batch = $this->POST('batch');
              $hargasatuan = $this->POST('pricePerPiece');
              $totalharga = $this->POST('priceAll');
              $expired = $this->POST('expired');
              $jumlahdata = count($itemCode);
              //Catat data di Penjualan
              
              M_Penjualan::getConnectionResolver()->connection()->beginTransaction();
                try{
                    $Trade 			    	      = new M_Penjualan();
                    $Trade->id_cabang       = $this->data['cabang']->id_cabang;
                    $Trade->id_user         = 1;
                    $Trade->total           = $totalharga;
                    $Trade->nama_pembeli    = $nama_pembeli;
                    $Trade->statusBon       = 0;
                    $Trade->uangMuka        = 0;
                    $Trade->statusVerifikasi= 1;
                    $Trade->no_hp           = $no_hp;
                  
                    $Trade->save();
                    $TransactionId = $Trade->id_penjualan;
                    M_Penjualan::getConnectionResolver()->connection()->commit();
                    for($i=0;$i<$jumlahdata;$i++){
                      $Barang = M_Obat::where('id_obat','=',$itemCode[$i])->first();
                      
                      M_BarangJual::getConnectionResolver()->connection()->beginTransaction();
                      try{
                        $Trade 			    	      = new M_BarangJual();
                        $Trade->id_penjualan    = $TransactionId;
                        $Trade->id_obat         = $itemCode[$i];
                        if($satuan[$i] == '1'){
                          $Trade->qty             = $qty[$i];
                          
                        }
                        if($satuan[$i] == '0'){
                          $Trade->qty             = $qty[$i]*$Barang->qtyPerBox;
                          $Trade->satuan        = 0;  
                        }
                        $Trade->diskon          = 0;
                        $Trade->online          = 1;
                        if($satuan[$i] == '1'){
                          $Trade->harga           = $Barang->harga_satuan * $qty[$i];
                        }
                        if($satuan[$i] == '0'){
                          $Trade->harga           = $Barang->hargaBox * $qty[$i];
                          
                        }
                        $Trade->save();
                        M_BarangJual::getConnectionResolver()->connection()->commit();
                      }
                      catch(Exception $e){
                        M_BarangJual::getConnectionResolver()->connection()->rollback();
                        $this->flashmsg($e->getMessage(), 'danger');
                        $this->go_back(-1);
                      }
                    }
                    $this->flashmsg('Data Transaksi Berhasil Diajukan');
                    redirect('https://wa.me/62821368308110?text=Saya%20Ingin%20Konfirmasi%20Pesanan%20dengan%20Nomor%20Order%20TRS-'.$TransactionId);
                    
                }
                
                catch (Exception $e){
                  M_Penjualan::getConnectionResolver()->connection()->rollback();
                  $this->flashmsg($e->getMessage(), 'danger');
                  $this->go_back(-1);
                  
                }      



        }

        $this->data['title'] 	= 'home';
        $this->data['content'] 	= 'cashier';
        $this->template($this->data, $this->module);
    }

    
    

    //get all medicine
    public function getMedicine(){
      $this->load->model('M_Obat');
      $waktu = date("Y-m");
      $waktu2=date("Y-m",strtotime($waktu . "+1 month"));
      $tahun = date('Y');
      $cabang = $this->session->userdata('branchId');
     
      $this->db->where('id_cabang',$cabang);
     // $this->db->where("DATE_FORMAT(expired_date,'%Y-%m') !=",$waktu);
     // $this->db->where("DATE_FORMAT(expired_date,'%Y-%m') !=",$waktu2);
      $this->data['obat'] = $this->db->get('obat')->result();
     
      echo json_encode([
        'status'	=> 'success',
        'data'		=> $this->data['obat']
      ]);

    }

    
}