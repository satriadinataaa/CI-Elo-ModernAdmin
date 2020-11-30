<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Update Stok Obat</h2>
                    <ol class="breadcrumb">
                        <li>
                        <a href="<?php echo base_url(); ?>Employee">Home</a>
                        </li>
                        <li class="active">
                            <strong>Update Stok Obat</strong>
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
                            <h5>Update Stok Obat</h5>
                        </div>
                        <div class="ibox-content">
                            <?= form_open_multipart('Employee/updateStock', ['class' => 'form-horizontal']) ?>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Nama Obat</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="Nama" name="name" class="form-control" id="name"> 
                                    </div>
                                </div>
                                <input type="hidden" name="id_obat" id="id_obat">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Sisa Stok ( Box )</label>
                                    <div class="col-lg-10">
                                        <input type="text" id="sisaStock" placeholder="Sisa Stok" name="sisaStock" class="form-control" disabled> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Sisa Stok ( Satuan )</label>
                                    <div class="col-lg-10">
                                        <input type="text" id="sisaStockSatuan" placeholder="Sisa Stok Satuan" name="sisaStockSatuan" class="form-control" disabled> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Tambah Stok Box</label>
                                    <div class="col-lg-10">
                                        <input type="number" placeholder="Tambah Stok Box" name="addStock" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <input type="submit" name="submit" value="Update" class="btn btn-sm btn-success">
                                    </div>
                                </div>
                            <?= form_close() ?>
                        </div>
                     </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
$(document).ready(function(){
    $( "#name" ).autocomplete({
        source: "<?php echo site_url('Employee/getMedicineNamebyCabang/?');?>"
    });

    $( "#name" ).change(function() {
        var nama_obat = $("#name").val();
        $.post('<?php echo base_url(); ?>Employee/getObatbyName', {
            name: nama_obat
        })
        .done(function(response) {
            var obj = JSON.parse(response);
            $("#sisaStock").val(obj.StockBox);
            $("#sisaStockSatuan").val(obj.stok);
            $("#id_obat").val(obj.id_obat);
        });
    });
});
    </script>