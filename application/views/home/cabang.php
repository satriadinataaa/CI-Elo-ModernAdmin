<div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Apotik Mura Farma</h2>
           <ol class="breadcrumb">
                <li>
                    <a href="<?php  base_url(); ?>home">Home</a>
                </li>
    
                <li class="active">
                    <strong>Pilih Cabang</strong>
                </li>
            </ol> 
        </div>
        <div class="col-lg-2">

        </div>
    </div>
        <div class="wrapper wrapper-content animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <?= $this->session->flashdata('msg') ?>
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Beli Obat</h5>
                        </div>
                        <div class="ibox-content">
                            
                            <?= form_open_multipart('Home', ['class' => 'form-horizontal','id'=>'formku']) ?>
                            
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Pilih Cabang</label>
                                    <div class="col-lg-10">
                                    <select name="cabang" class="form-control">
                                        <option disabled selected >Pilih Cabang</option>
                                        <?php foreach ($cabang as $i => $cabang): ?>
                                        <option value="<?= $cabang->id_cabang?>"><?= $cabang->nama_cabang?></option>
                                        <?php endforeach;?>
                                    </select>
                                        
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <input type="submit" name="submit" value="Transaksi" id="submit" class="btn btn-success">
                                      
                                    </div>
                                </div>
                                
                            <?= form_close() ?>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

    

  
