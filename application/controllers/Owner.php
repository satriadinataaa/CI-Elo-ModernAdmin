<?php  

class Owner extends MY_Controller
{
    public function __construct()
    {
      parent::__construct();
      if($this->session->userdata('id_role') != '1'){
        $this->session->sess_destroy();
        redirect('login');
        }
      $this->data['name'] = $this->session->userdata('name');
      $this->module = 'Owner';
    }
    public function index(){
       redirect('Owner/allProfit');
    } 

    //create and update branch data
    public function createBranch(){
      $this->load->model('M_Cabang');
      if ($this->POST('delete')) {
        M_Cabang::where('id_cabang', '=', $this->POST('id_cabang'))->delete();
              echo json_encode('berhasil');
              redirect('Owner/createBranch','refresh');
              exit;
      }
      if ($this->POST('edit'))
      {
          M_Cabang::getConnectionResolver()->connection()->beginTransaction();
          try{
                $Cabang 			    	  = M_Cabang::find($this->POST('id_cabang'));
                $Cabang->nama_cabang	= $this->POST('name');
                $Cabang->alamat	= $this->POST('address');
                $Cabang->no_hp 		  = $this->POST('telepon');
                $Cabang->save();
                M_Cabang::getConnectionResolver()->connection()->commit();
                $this->flashmsg('Cabang berhasil diperbarui');
                redirect('Owner/createBranch');
              
          }
          catch (Exception $e){
              M_Cabang::getConnectionResolver()->connection()->rollback();
              $this->flashmsg($e->getMessage(), 'danger');
              $this->go_back(-1);
          }      
      }
      if ($this->POST('submit'))
      {
          M_Cabang::getConnectionResolver()->connection()->beginTransaction();
          try{
                $Cabang 			    	  = new M_Cabang();
                $Cabang->nama_cabang	= $this->POST('name');
                $Cabang->alamat	= $this->POST('address');
                $Cabang->no_hp 		  = $this->POST('telepon');
                $Cabang->save();
                M_Cabang::getConnectionResolver()->connection()->commit();
                $this->flashmsg('Cabang baru berhasil dibuat');
                redirect('Owner/createBranch');
              
          }
          catch (Exception $e){
              M_Cabang::getConnectionResolver()->connection()->rollback();
              $this->flashmsg($e->getMessage(), 'danger');
              $this->go_back(-1);
          }      
      }
            
      $this->data['cabang'] = M_Cabang::get();
      $this->data['title']  = 'home';
      $this->data['content']   = 'branch';
      $this->template($this->data, $this->module);
      
    }
    //create and update employee data also assign its branch
    public function createEmployee(){
       $this->load->model('M_Cabang');
       $this->load->model('M_Users');
       
       if ($this->POST('delete')) {
        M_Users::where('id_user', '=', $this->POST('id_user'))->delete();
              echo json_encode('berhasil');
              redirect('Owner/createEmployee','refresh');
              exit;
       }
      if ($this->POST('edit'))
      {
          M_Users::getConnectionResolver()->connection()->beginTransaction();
          try{
                $User 			    	    = M_Users::find($this->POST('id_user'));
                $User->no_hp 		      = $this->POST('telepon');
                $User->id_cabang 		  = $this->POST('branch');
                $User->save();
                M_Users::getConnectionResolver()->connection()->commit();
                $this->flashmsg('User berhasil diperbarui');
                redirect('Owner/createEmployee');
              
          }
          catch (Exception $e){
              M_Users::getConnectionResolver()->connection()->rollback();
              $this->flashmsg($e->getMessage(), 'danger');
              $this->go_back(-1);
          }      
      }
      
       if($this->POST('submit')){
       
          M_Users::getConnectionResolver()->connection()->beginTransaction();
          try{
              $User 			    	  = new M_Users();
              $User->nama       	= $this->POST('name');
              $User->no_hp 		    = $this->POST('telepon');
              $User->id_cabang  	= $this->POST('branch');
              $User->username  	  = $this->POST('username');
              $User->password  	  = md5($this->POST('password'));
              $User->id_role      = 2;
              $User->save();
              M_Users::getConnectionResolver()->connection()->commit();
              $this->flashmsg('User baru berhasil dibuat');
              redirect('Owner/createEmployee');
            }
          catch (Exception $e){
            M_Users::getConnectionResolver()->connection()->rollback();
            $this->flashmsg($e->getMessage(), 'danger');
            $this->go_back(-1);
        }      
       }
       $this->data['user'] = M_Users::with('cabang')
                          ->where('id_role','!=',1)->get();
    
       $this->data['cabang'] = M_Cabang::get();
       $this->data['cabang_modal'] = M_Cabang::get();
       $this->data['title']  = 'home';
       $this->data['content']   = 'employee';
       $this->template($this->data, $this->module);
    }

    //chencking profit with filter month and year
    public function allProfit($value=''){
      $this->load->model('M_Obat');
      $this->load->model('M_Cabang');
      $this->load->model('M_Penjualan');
      $this->load->model('M_BarangJual');

       if($this->POST('submit')){
        $this->data['bulan'] = $this->POST('month');
        $this->data['tahun'] = $this->POST('year');
        
        $this->data['laporan'] = M_Cabang::with(['user' => function($query){
                                    $query->where('id_role','!=',1);
                                 }//,'penjualan' => function($query){
                                 // $query->whereMonth('created_at','=',$this->data['month']);
                                 //$query->whereYear('created_at','=',$this->data['year']);
                                // }
                                 ])
                                 ->join('penjualan','cabang.id_cabang','=','penjualan.id_cabang')
                                 ->whereMonth('penjualan.created_at','=',$this->data['bulan'])
                                 ->whereYear('penjualan.created_at','=',$this->data['tahun'])
                                 ->groupBy('cabang.id_cabang')
                                 ->get();
                                
                                 
      }
     // echo $this->data['laporan'];die();
        $i=0;
        if(isset($this->data['laporan'])){
        foreach ($this->data['laporan'] as $j => $l):
          $this->data['total'][$i] = M_Penjualan::where('id_cabang','=',$l->id_cabang)
                                    ->where('statusVerifikasi','=',)->sum('total');  
          $i++;
        endforeach;
        }
      
      //print_r($this->data['total']);die();
      $this->data['month'] = date("m");
      $this->data['year'] = date("Y");
      $this->data['title']  = 'home';
       $this->data['content']   = 'profit';
       $this->template($this->data, $this->module);
    }

    //all medicine thats gonna expired in 1 month
    public function expiredMedicine($value=''){
      $this->load->model('M_Obat');
      $this->load->model('M_Cabang');
      if ($this->POST('delete')) {
        M_Obat::where('id_obat', '=', $this->POST('id_obat'))->delete();
              echo json_encode('berhasil');
              redirect('Owner/expiredMedicine','refresh');
              exit;
       }
      $now = date("Y/m/d");
      $sixtydays = strtotime($now."+180 days");
      $sixtydays = date("Y-m-d",$sixtydays);
      
      $this->data['expired'] = M_obat::with('cabang')
                              ->where('expired_date','<=',$sixtydays)->get();
     
      $this->data['title']  = 'home';
      $this->data['content']   = 'expired';
      $this->template($this->data, $this->module);
    }

}