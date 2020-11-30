<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Obat</h2>
                    <ol class="breadcrumb">
                        <li>
                        <a href="<?php echo base_url(); ?>Employee">Home</a>
                        </li>
                        <li class="active">
                            <strong>Obat</strong>
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
                            <h5>Check Obat</h5>
                        </div>
                        <div class="ibox-content">
                            <?= form_open_multipart('Employee/checkMedicine', ['class' => 'form-horizontal']) ?>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Nama Obat</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="Nama" name="name" class="form-control" id="name"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <input type="submit" name="submit" value="Cari" class="btn btn-sm btn-success">
                                    </div>
                                </div>
                            <?= form_close() ?>
                        </div>
                     </div>
                    <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Obat</h5>
                    </div>
                    <div class="ibox-content">

                        <table class="table dataTables-example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Obat</th>
                                    <th>No. Batch</th>
                                    <th>Expired</th>
                                    <th>Stock</th>
                                    <th>Stock (Box) </th>
                                    <th>Harga Satuan</th>
                                    <th>Harga Box</th>
                                    <th>Letak Obat</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($Medicine)){?>
                            <?php foreach ($Medicine as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= $row->nama ?></td>
                                    <td><?= $row->no_batch ?></td>
                                    <td><?= $row->expired_date ?></td>
                                    <td><?= $row->stok ?></td>
                                    <td><?= $row->StockBox ?></td>
                                    <td><?= $row->harga_satuan ?></td>
                                    <td><?= $row->hargaBox ?></td>
                                    <td><?= $row->LetakObat ?></td>
                                    
                                </tr>
                                <?php endforeach; ?> 
                            <?php }?>
                            </tbody>
                        </table>

                    </div>
                </div>
                    
                 </div>
             </div>
<script type="text/javascript">
$(document).ready(function(){
    $( "#name" ).autocomplete({
        source: "<?php echo site_url('Employee/getMedicineNamebyCabang/?');?>"
    });

   
});
    </script>