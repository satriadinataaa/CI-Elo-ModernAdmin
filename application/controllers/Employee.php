<?php  

class Employee extends MY_Controller
{
	  public function __construct()
    {
     
      parent::__construct();
      if($this->session->userdata('id_role') != '2'){
        $this->session->sess_destroy();
        redirect('login');
        }
      $this->load->model('M_Cabang');
      $this->data['name'] = $this->session->userdata('name');
      $this->data['branchId'] = $this->session->userdata('cabang');
      $this->data['id_user'] = $this->session->userdata('account_id');
      $branch = M_Cabang::find($this->data['branchId']);
      $this->data['branchName'] = $branch->nama_cabang;
      $this->load->library('pdf');
      $this->module = 'employee';
    }


    public function getMedicineNamebyCabang(){
      $this->load->model('M_Obat');
      $obat = M_Obat::where('id_cabang','=',$this->data['branchId'])->get();
      if(count($obat) > 0){
        foreach($obat as $o){
          $name[] = $o->nama;
         // echo json_encode($name);
        }
      }
      echo json_encode($name);
    }

   

    

    public function getMedicineIdbyCabang(){
      $this->load->model('M_Obat');
      $obat = M_Obat::where('id_cabang','=',$this->data['branchId'])->get();
      if(count($obat) > 0){
        foreach($obat as $o){
          $name[] = strval($o->id_obat);
         // echo json_encode($name);
        }
      }
      echo json_encode($name);
    }

    public function getObatbyId(){
      $this->load->model('M_Obat');
      if($this->POST('id')){
        $obat = M_Obat::where('id_obat','=',$this->POST('id'))
                        ->where('id_cabang','=',$this->data['branchId'])
                        ->first();
       
      }
      echo json_encode($obat);
    }

    public function getObatbyName(){
      $this->load->model('M_Obat');
      if($this->POST('name')){
        $obat = M_Obat::where('nama','LIKE','%'.$this->POST('name').'%')
                        ->where('id_cabang','=',$this->data['branchId'])
                        ->first();
       
      }
      echo json_encode($obat);
    }

    public function checkStock(){
      $returntype=true;
      $askedStock = $this->POST('stok');
      $id = $this->POST('id');
      $this->load->model('M_Obat');
      $stockAvailable = $obat = M_Obat::where('id_obat','=',$id)
                          ->where('id_cabang','=',$this->data['branchId'])
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
          $refresh=false;
          
          if($this->POST('submit')){
              $this->load->model('M_Obat');
              $this->load->model('M_Penjualan');
              $this->load->model('M_BarangJual');
              $date = date('d-m-Y');
              $nama_pembeli = $this->POST('buyer_name');
              $no_hp = $this->POST('no_hp');
              $diskongrosir = $this->POST('diskongrosir');
              
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
                    $Trade->id_cabang       = $this->data['branchId'];
                    $Trade->id_user         = $this->data['id_user'];
                    $Trade->total           = $totalharga;
                    $Trade->nama_pembeli    = $nama_pembeli;
                    if($this->POST('cekBon') == "on"){
                      $Trade->statusBon     = 1;
                      
                      $Trade->uangMuka = $this->POST('uangMuka');
                    }
                    else{
                      $Trade->statusBon = 0;
                      $Trade->uangMuka = 0;
                    }

                    $Trade->no_hp           = $no_hp;
                  
                    $Trade->save();
                    $TransactionId = $Trade->id_penjualan;
                    M_Penjualan::getConnectionResolver()->connection()->commit();
                    $pdf = new FPDF();
                    $pdf->AddPage();
                    // setting jenis font yang akan digunakan
                    $pdf->SetFont('Arial','B',16);
                    // mencetak string 
                    $pdf->Cell(190,7,'Apotik Mura Farma',0,1,'C');
                    $pdf->Ln(10);
                    $pdf->SetFont('Arial','',10);
                    $pdf->Cell(10,7,'Nama Pelanggan:',0,0);
                    $pdf->Cell(30);
                    $pdf->Cell(10,7,$nama_pembeli,0,0);
                    $pdf->Cell(80);
                    $pdf->Cell(10,7,'No Handphone:',0,0);
                    $pdf->Cell(30);
                    $pdf->Cell(10,7,$no_hp,0,1);
                    
                    $pdf->Cell(10,7,'Nama Kasir:',0,0);
                    $pdf->Cell(30);
                    $pdf->Cell(10,7,$this->data['name'],0,0);
                    $pdf->Cell(80);
                    $pdf->Cell(10,7,'Tanggal:',0,0);
                    $pdf->Cell(30);
                    $pdf->Cell(10,7,$date,0,1);

                    if($this->POST('cekBon') == "on"){
                    $pdf->Cell(10,7,'Status Pembelian:',0,0);
                    $pdf->Cell(30);
                    $pdf->Cell(10,7,'Bon',0,0);
                    $pdf->Cell(80);
                    $pdf->Cell(10,7,'Sisa:',0,0);
                    $pdf->Cell(30);
                    $pdf->Cell(10,7,$totalharga-intval($this->POST('uangMuka')),0,1);
                    }
                    if($this->POST('cekBon') == "off"){
                      $pdf->Cell(10,7,'Status Pembelian:',0,0);
                      $pdf->Cell(30);
                      $pdf->Cell(10,7,'Lunas',0,0);
                      $pdf->Cell(80);
                      $pdf->Cell(10,7,'Sisa:',0,0);
                      $pdf->Cell(30);
                      $pdf->Cell(10,7,'0',0,1);
                      }
                    //Catat data di barang jual
                        $pdf->Cell(10,7,'',0,1);
                        $pdf->SetFont('Arial','B',10);
                       
                        $pdf->Cell(30,10,'Kode Barang',1,0,'C');
                        $pdf->Cell(40,10,'Nama Barang',1,0,'C');
                        $pdf->Cell(10 ,10,'Qty',1,0,'C');
                        $pdf->Cell(20,10,'No Batch',1,0,'C');
                        $pdf->Cell(20,10,'Expired',1,0,'C');
                        $pdf->Cell(30,10,'Harga Satuan',1,0,'C');
                        $pdf->Cell(15,10,'Diskon',1,0,'C');
                        $pdf->Cell(30,10,'Harga',1,0,'C');
                        $pdf->Ln(10);
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
                        $Trade->diskon          = $diskongrosir[$i];
                        if($satuan[$i] == '1'){
                          $Trade->harga           = $Barang->harga_satuan * $qty[$i];
                        }
                        if($satuan[$i] == '0'){
                          $Trade->harga           = $Barang->hargaBox * $qty[$i];
                          
                        }
                        $Trade->save();
                        $totalbelanja[$i] = $hargasatuan[$i]*$qty[$i];
                       
                        $pdf->SetFont('Arial','B',8);
                        
                        $pdf->Cell(30,10,$itemCode[$i],1,0,'C');
                        $pdf->Cell(40,10,$itemName[$i],1,0,'C');
                        if($satuan[$i] == '1'){
                        $pdf->Cell(10 ,10,$qty[$i].'Buah' ,1,0,'C');
                        }
                        if($satuan[$i] == '0'){
                          $pdf->Cell(10 ,10,$qty[$i].'Box' ,1,0,'C');
                        }
                        $pdf->Cell(20,10,$batch[$i],1,0,'C');
                        $pdf->Cell(20,10,$expired[$i],1,0,'C');
                        $pdf->Cell(30,10,'Rp. '.$hargasatuan[$i],1,0,'C');
                        $pdf->Cell(15,10,$diskongrosir[$i].'%',1,0,'C');
                        $pdf->Cell(30,10,'Rp. '. (floatval($totalbelanja[$i]) - (floatval($totalbelanja[$i]) * (floatval($diskongrosir[$i])/100))),1,0,'C');
                        $pdf->Ln(10);
                        M_BarangJual::getConnectionResolver()->connection()->commit();

                        //Kurangi Jumlah Obat
                        M_Obat::getConnectionResolver()->connection()->beginTransaction();
                        $currentStock = M_Obat::where('id_obat','=',$itemCode[$i])->first();
                        
                        try{
                              $Obat 			    	      = M_Obat::find($itemCode[$i]);
                              if($satuan[$i] == '1'){
                                $Obat->stok 		      = $currentStock->stok - $qty[$i];
                                $Obat->StockBox       = floor(($currentStock->stok - $qty[$i])/$currentStock->qtyPerBox);
                              }
                              if($satuan[$i] =='0'){
                                $Obat->StockBox 		  = $currentStock->StockBox - $qty[$i];
                                $Obat->stok           = $currentStock->stok - ($currentStock->qtyPerBox * $qty[$i]);
                              }
                              $Obat->save();
                              M_Obat::getConnectionResolver()->connection()->commit();
                              
                            
                        }
                        catch (Exception $e){
                         
                            M_Obat::getConnectionResolver()->connection()->rollback();
                            $this->flashmsg($e->getMessage(), 'danger');
                            $this->go_back(-1);
                        }     

                      }
                    
                      catch(Exception $e){
                        M_BarangJual::getConnectionResolver()->connection()->rollback();
                        $this->flashmsg($e->getMessage(), 'danger');
                        $this->go_back(-1);
                      }
                   }
                   
                    $this->flashmsg('Data Transaksi Berhasi Di input');
                   
                    $namafile = $date. '_'.$TransactionId.'.pdf';
                    $pdf->Output($namafile,'D');
                   
                   
                   
                    
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

    //Create and update medicine data
      public function createMedicine(){
        $this->load->model('M_Obat');
        if ($this->POST('delete')) {
          M_Obat::where('id_obat', '=', $this->POST('id_obat'))->delete();
                echo json_encode('berhasil');
                redirect('Employee/createMedicine','refresh');
                exit;
        }
        if ($this->POST('edit')){
          M_Obat::getConnectionResolver()->connection()->beginTransaction();
          $modal = $this->POST('modal');
          $hargaBox = $modal + ($modal * (12/100));
          try{
              $Obat                   = M_Obat::find($this->POST('id_obat'));
              $Obat->nama           	= $this->POST('name');
              $Obat->no_batch 		    = $this->POST('batch');
              $Obat->id_cabang  	    = $this->data['branchId'];
              $Obat->StockBox         = $this->POST('Stock');
              $Obat->qtyPerBox        = $this->POST('qty');
              $Obat->expired_date  	  = $this->POST('expiredDate');
              $Obat->stok  	          = $this->POST('Stock')*$this->POST('qty');
              $Obat->harga_satuan  	  = $this->POST('price');
              $Obat->modal            = $this->POST('modal');
              $Obat->hargaBox         = $hargaBox;
              $Obat->LetakObat  	    = $this->POST('place');

              $Obat->save();
              M_Obat::getConnectionResolver()->connection()->commit();
              $this->flashmsg('Data Obat berhasil diperbarui');
              redirect('Employee/createMedicine');
            }
            
          catch (Exception $e){
            M_Obat::getConnectionResolver()->connection()->rollback();
            $this->flashmsg($e->getMessage(), 'danger');
            $this->go_back(-1);
        }      
        }
        if($this->POST('submit')){
          M_Obat::getConnectionResolver()->connection()->beginTransaction();
          $modal = $this->POST('modal');
          $hargaBox = $modal + ($modal * (12/100));
          try{
              $Obat 			    	      = new M_Obat();
              $Obat->nama           	= $this->POST('name');
              $Obat->no_batch 		    = $this->POST('batch');
              $Obat->id_cabang  	    = $this->data['branchId'];
              $Obat->StockBox         = $this->POST('Stock');
              $Obat->qtyPerBox        = $this->POST('qty');
              $Obat->expired_date  	  = $this->POST('expiredDate');
              $Obat->stok  	          = $this->POST('Stock')*$this->POST('qty');
              $Obat->harga_satuan  	  = $this->POST('price');
              $Obat->modal            = $this->POST('modal');
              $Obat->hargaBox         = $hargaBox;
              $Obat->LetakObat  	    = $this->POST('place');
            
              $Obat->save();
              M_Obat::getConnectionResolver()->connection()->commit();
              $this->flashmsg('Obat baru berhasil diinput');
              redirect('Employee/createMedicine');
            }
            
          catch (Exception $e){
            M_Obat::getConnectionResolver()->connection()->rollback();
            $this->flashmsg($e->getMessage(), 'danger');
            $this->go_back(-1);
        }      
        }
        $this->data['Medicine'] = M_Obat::where('id_cabang','=',$this->data['branchId'])
                                          ->OrderBy('created_at','desc')->get();
        $this->data['title'] 	= 'home';
        $this->data['content'] 	= 'medicine';
        $this->template($this->data, $this->module);
    }

    //Update medicine stock
    public function updateStock(){
      $this->load->model('M_Obat');
      if($this->POST('submit')){
        M_Obat::getConnectionResolver()->connection()->beginTransaction();
        $currentStock = M_Obat::where('id_obat','=',$this->POST('id_obat'))->first();
        
        try{
            
            $Obat                   = M_Obat::find($this->POST('id_obat'));
           
            $Obat->stok  	          = $currentStock->stok + ($this->POST('addStock')*$currentStock->qtyPerBox);
            $Obat->stockBox         = floor(($currentStock->stok + ($this->POST('addStock')*$currentStock->qtyPerBox)) / ($currentStock->qtyPerBox));
          
            $Obat->save();
            M_Obat::getConnectionResolver()->connection()->commit();
            $this->flashmsg('Data Obat berhasil diperbarui');
            redirect('Employee/updateStock');
          }
          
        catch (Exception $e){
          M_Obat::getConnectionResolver()->connection()->rollback();
          $this->flashmsg($e->getMessage(), 'danger');
          $this->go_back(-1);
      }      
      }
      $this->data['title'] 	= 'home';
      $this->data['content'] 	= 'stock';
      $this->template($this->data, $this->module);
    }

    //checking medicine info (if customer asking)
    public function checkMedicine()
    {
      $this->load->model('M_Obat');
      $this->data['Medicine'] = null;
      if($this->POST('submit')){
        $this->data['Medicine'] = M_obat::with('cabang')
                                ->where('id_cabang',$this->data['branchId'])
                                ->where('nama',$this->POST('name'))
                                ->get();
      }
      $this->data['title'] 	= 'home';
      $this->data['content'] 	= 'checking';
      $this->template($this->data, $this->module);
    }

    //cashier
    public function cashier(){
      # code...
    }

    //all medicine thats gonna expired in 1 month
    public function expiredMedicine()
    {
      $this->load->model('M_Obat');
      $this->load->model('M_Cabang');
      if ($this->POST('delete')) {
        M_Obat::where('id_obat', '=', $this->POST('id_obat'))->delete();
              echo json_encode('berhasil');
              redirect('Employee/expiredMedicine','refresh');
              exit;
       }
      $now = date("Y/m/d");
      $sixtydays = strtotime($now."+180 days");
      $sixtydays = date("Y-m-d",$sixtydays);
     
      $this->data['expired'] = M_obat::with('cabang')
                              ->where('id_cabang',$this->data['branchId'])
                              ->where('expired_date','<=',$sixtydays)
                              ->OrderBy('created_at','desc')->get();
              
                            
      $this->data['title']  = 'home';
      $this->data['content']   = 'expired';
      $this->template($this->data, $this->module);

      
    }

    //get all medicine
    public function getMedicine(){
      $this->load->model('M_Obat');
      $waktu = date("Y-m");
      $waktu2=date("Y-m",strtotime($waktu . "+1 month"));
      $tahun = date('Y');
      $cabang = $this->data['branchId'];
     
      $this->db->where('id_cabang',$cabang);
     // $this->db->where("DATE_FORMAT(expired_date,'%Y-%m') !=",$waktu);
     // $this->db->where("DATE_FORMAT(expired_date,'%Y-%m') !=",$waktu2);
      $this->data['obat'] = $this->db->get('obat')->result();
     
      echo json_encode([
        'status'	=> 'success',
        'data'		=> $this->data['obat']
      ]);

    }

    public function kasBon(){
      $this->load->model('M_Penjualan');
      $this->data['bon'] = M_Penjualan::where('id_cabang','=',$this->data['branchId'])
                                        ->where('statusBon','=','1')->get();
                                        
     
      $this->data['title'] 	= 'home';
      $this->data['content'] 	= 'daftarBon';
      $this->template($this->data, $this->module);
    }

    public function Lunasi(){
      $this->load->model('M_Penjualan');
      if ($this->POST('lunasi')) {
        try{
          $Penjualan                   = M_Penjualan::find($this->POST('id_penjualan'));
          $Penjualan->statusBon         = 0;
          $Penjualan->save();
          M_Penjualan::getConnectionResolver()->connection()->commit();
          $this->flashmsg('Data Penjualan berhasil diperbarui');
          echo json_encode('berhasil');
          redirect('Employee/kasBon','refresh');
          exit;
        }
        catch (Exception $e){
          M_Obat::getConnectionResolver()->connection()->rollback();
          $this->flashmsg($e->getMessage(), 'danger');
          $this->go_back(-1);
      }      
       
    }
    }
    
    public function transaksiOnline(){
      $this->load->model('M_Penjualan');
      
      if($this->POST('proses')){
        M_Penjualan::where('id_penjualan', '=', $this->POST('id_penjualan'))->delete();
        echo json_encode('berhasil');
        redirect('Employee/transaksiOnline','refresh');
        exit;
      }

      
      $this->data['online'] = M_Penjualan::where('id_cabang','=',$this->data['branchId'])
                                        ->where('statusVerifikasi','=','1')
                                        ->OrderBy('created_at','DESC')->get();
      

      $this->data['title'] 	= 'home';
      $this->data['content'] 	= 'online';
      $this->template($this->data, $this->module);
    
    }

    public function prosesOnline(){
      $this->load->model('M_Penjualan');
      $this->load->model('M_BarangJual');
      $this->load->model('M_Obat');
      if ($this->POST('proses')) {
        $id_penjualan = $this->POST('id_penjualan');
        $this->data['barang_jual'] = M_BarangJual::where('id_penjualan','=',$id_penjualan)
                                                  ->where('statusVerifikasi','=','1')
                                                  ->get();

        try{
          $Penjualan                   = M_Penjualan::find($this->POST('id_penjualan'));
          $Penjualan->statusBon         = 0;
          $Penjualan->save();
          M_Penjualan::getConnectionResolver()->connection()->commit();
          $this->flashmsg('Data Penjualan berhasil diperbarui');
          echo json_encode('berhasil');
          redirect('Employee/kasBon','refresh');
          exit;
        }
        catch (Exception $e){
          M_Obat::getConnectionResolver()->connection()->rollback();
          $this->flashmsg($e->getMessage(), 'danger');
          $this->go_back(-1);
      }      
       
    }
    }

    public function detailOnline(){
        $this->load->model('M_BarangJual');
        $this->load->model('M_Penjualan');
        $this->data['data_order'] = $this->uri->segment(3);
      
        $this->data['barang_jual'] = M_BarangJual::with('obat')
                                                 ->where('id_penjualan','=',$this->data['data_order'])->get();
        
        $this->data['penjualan'] = M_Penjualan::where('id_penjualan','=',$this->data['data_order'])->first();

        $this->data['title'] 	= 'Detail Order';
        $this->data['content'] 	= 'detailOrder';
        $this->template($this->data, $this->module);
     
    }

    public function hapusPenjualan(){
      $this->load->model('M_Penjualan');
      
    }
    
}