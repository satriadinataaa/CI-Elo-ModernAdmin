    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2><?= $branchName ?></h2>
           <ol class="breadcrumb">
                <li>
                <a href="<?php echo base_url(); ?>Employee">Home</a>
                </li>
    
                <li class="active">
                    <strong>Kasir</strong>
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
                            <h5>Kasir</h5>
                        </div>
                        <div class="ibox-content">
                            
                            <?= form_open_multipart('Employee', ['class' => 'form-horizontal','id'=>'formku']) ?>
                            
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Nama</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="Nama Pembeli" name="buyer_name" id="buyer_name" class="form-control" required> 
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                 <div class="form-group">
                                    <label class="col-lg-2 control-label">No handphone</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="No Hp Pembeli" name="no_hp" id="no_hp" class="form-control" > 
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Barang</label>
                                    <div class="col-lg-12">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Kode Barang</th>
                                                    <th>Nama Barang</th>
                                                    <th>Satuan</th>
                                                    <th>Qty </th>
                                                    <th>No Batch</th>
                                                    <th>Expired</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Diskon Grosir</th>
                                                    <th>Harga</th>
                                                    <th>-</th>
                                                </tr>
                                            </thead>
                                            <tbody id="item-container">
                                                <tr>
                                                    <td class="item-number">1</td>
                                                    <td>
                                                        <input type="text" name="itemCode[]" id="id_obat_1" placeholder="Kode Barang" class="form-control" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="itemName[]" id="nama_1" placeholder="Nama Barang" class="form-control" required>
                                                    </td>
                                                    <td>
                                                        <select name="satuan[]" class="form-control" id="satuan_1">
                                                            <option value="1">Satuan</option>
                                                            <option value="0">Box</option>
                                                        </select>
                                                      
                                                    </td>
                                                    <td>
                                                        <input type="text" name="qty[]" id="qty_1" placeholder="Qty" class="form-control" required >
                                                    </td>
                                                    <td>
                                                        <input type="text" name="batch[]" id="batch_1" placeholder="No Batch" class="form-control" disabled required>
                                                    </td>
                                                    
                                                    <td>
                                                        <input type="text" name="expired[]" id="expired_1" placeholder="Expired" class="form-control" disabled required>
                                                    </td>
                                                   
                                                    <td>
                                                        <div class="input-group m-b">
                                                            <!--<span class="input-group-addon">Rp.</span>-->
                                                            <input type="text" placeholder="Harga Satuan" name="pricePerPiece[]" id="hargasatuan_1" class="form-control" disabled required> 
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group m-b">
                                                            
                                                            <input type="text" placeholder="Diskon Grosir" name="diskongrosir[]" id="diskongrosir_1" class="form-control" > 
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                    <div class="input-group m-b">
                                                            <!--<span class="input-group-addon">Rp.</span>-->
                                                            <input type="text" placeholder="Harga" name="item_budget_ceiling[]" id="totalharga_1" class="form-control" disabled required> 
                                                        </div>
                                                    </td>
                                                    <td>
                                                    <!--<input type="hidden" name="idObat[]"   --> 
                                                        <button type="button" onclick="remove_item(this);" class="btn btn-danger btn-sm">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-warning btn-sm" id="add-item-button" onclick="add_item();">
                                            <i class="fa fa-plus"></i> Tambah Item
                                        </button>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group cekbox">
                                    <label class="col-lg-2 control-label"></label>

                                <label> <input type="checkbox" name="cekBon" class="i-checks price-of-package-element"> Transaksi Bon </label>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Total Sementara</label>
                                    <div class="col-lg-10">
                                        <div class="input-group m-b">
                                            <span class="input-group-addon">Rp.</span>
                                            <input type="text" placeholder="Total" name="priceAll" id="priceAll" class="form-control" disabled> 
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed " id="totalsementara"></div>
                               
                                <hr>
                                
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <input type="submit" name="submit" value="Transaksi" id="submit" class="btn btn-success">
                                        <a href="<?= base_url()?>" class="btn btn-primary">Refresh</a>
                                        <p style="color:red">*Transaksi tidak dapat dirubah setelah diproses</p>
                                    </div>
                                </div>
                                
                            <?= form_close() ?>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

    

    <script type="text/javascript">
        let numItems = 1;
        let numbering =1;
        
        $('#formku').submit(function(e) {
           

            $(':disabled').each(function(e) {
                $(this).removeAttr('disabled');
            });
            
            
        });

        $( "#id_obat_1" ).autocomplete({
            source: "<?php echo site_url('Employee/getMedicineIdbyCabang/?');?>"
        });

        $( "#nama_1" ).autocomplete({
            source: "<?php echo site_url('Employee/getMedicineNamebyCabang/?');?>"
        });

        $( "#nama_1" ).change(function() {
            var nama = $("#nama_1").val();
            $.post('<?php echo base_url(); ?>Employee/getObatbyName', {
                name: nama
            })
            .done(function(response) {
                var obj = JSON.parse(response);
                $("#id_obat_1").val(obj.id_obat);
                $("#batch_1").val(obj.no_batch);
                $("#expired_1").val(obj.expired_date);
                $("#hargasatuan_1").val(obj.harga_satuan);
                $("#qty_1").val(0);
                $("#totalharga_1").val(0);
                var totalall = 0;
                for(var i=1;i<=numItems;i++){
                    if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                        totalall += 0;
                    }
                    else{
                    totalall += parseInt($("#totalharga_"+i).val(),0);
                    }
                    
                }
                $("#priceAll").val(totalall);
            });
        });

        $( "#satuan_1" ).change(function() {
            var nama = $("#nama_1").val();
            var satuan = $("#satuan_1").val();
            $.post('<?php echo base_url(); ?>Employee/getObatbyName', {
                name: nama
            })
            .done(function(response) {
                if(satuan == 1){
                var obj = JSON.parse(response);
                $("#id_obat_1").val(obj.id_obat);
                $("#batch_1").val(obj.no_batch);
                $("#expired_1").val(obj.expired_date);
                $("#hargasatuan_1").val(obj.harga_satuan);
                $("#qty_1").val(0);
                $("#totalharga_1").val(0);
                var totalall = 0;
                for(var i=1;i<=numItems;i++){
                    if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                        totalall += 0;
                    }
                    else{
                    totalall += parseInt($("#totalharga_"+i).val(),0);
                    }
                    
                }
                $("#priceAll").val(totalall);
                }
                
                if(satuan == 0){
                    var obj = JSON.parse(response);
                $("#id_obat_1").val(obj.id_obat);
                $("#batch_1").val(obj.no_batch);
                $("#expired_1").val(obj.expired_date);
                $("#hargasatuan_1").val(obj.hargaBox);
                $("#qty_1").val(0);
                $("#totalharga_1").val(0);
                var totalall = 0;
                for(var i=1;i<=numItems;i++){
                    if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                        totalall += 0;
                    }
                    else{
                    totalall += parseInt($("#totalharga_"+i).val(),0);
                    }
                    
                }
                $("#priceAll").val(totalall);
                }
            });
        });
        
        $( "#id_obat_1" ).change(function() {
            var id_obat = $("#id_obat_1").val();
            $.post('<?php echo base_url(); ?>Employee/getObatbyId', {
                id: id_obat
            })
            .done(function(response) {
                var obj = JSON.parse(response);
                $("#nama_1").val(obj.nama);
                $("#batch_1").val(obj.no_batch);
                $("#expired_1").val(obj.expired_date);
                $("#hargasatuan_1").val(obj.harga_satuan);
                $("#qty_1").val(0);
                $("#totalharga_1").val(0);
                var totalall = 0;
                for(var i=1;i<=numItems;i++){
                    if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                        totalall += 0;
                    }
                    else{
                    totalall += parseInt($("#totalharga_"+i).val(),0);
                    }
                    
                }
                $("#priceAll").val(totalall);
            });
        });
        $( "#qty_1" ).change(function() {
            var qty = $("#qty_1").val();
            var id_obat = $("#id_obat_1").val();
            var diskon;
            if($("#diskongrosir_1").val().length == 0){
                diskon = 0;
            }
            else{
                diskon = parseFloat($("#diskongrosir_1").val());
            } 
            
                      
             $.post('<?php echo base_url(); ?>Employee/checkStock', {
                id: id_obat,
                stok : qty
            })
            .done(function(response) {
               
                if(response == "true"){
                    if(diskon < 0 && diskon >= 100 ){
                        diskon = 0;
                     }
                    var harga_satuan = $('#hargasatuan_1').val();
                    var totalharga = qty*harga_satuan;
                    
                    if(diskon != 0){
                        diskonku = totalharga * ((diskon)/100);
                        totalharga -= diskonku;
                    }
                    $("#totalharga_1").val(totalharga);
                    var totalall = 0;
                    for(var i=1;i<=numItems;i++){
                        if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                            totalall += 0;
                        }
                        else{
                            totalall += parseInt($("#totalharga_"+i).val(),0);
                        }
                    
                    }
                    $("#priceAll").val(totalall);
                }
                else{
                    var zero = 0;
                    var totalharga = 0;
                    swal("Stok Tidak Cukup !");
                    $("#qty_1").val(zero);
                    $("#totalharga_1").val(totalharga);
                    var totalall = 0;
                    for(var i=1;i<=numItems;i++){
                        if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                                    totalall += 0;
                                }
                                else{
                                totalall += parseInt($("#totalharga_"+i).val(),0);
                                }
                        
                    }
                    $("#priceAll").val(totalall);
                    
                }
            });
        });
        $( "#diskongrosir_1" ).change(function() {
            var qty = $("#qty_1").val();
            var id_obat = $("#id_obat_1").val();
            var diskon;
            if($("#diskongrosir_1").val().length == 0){
                diskon = 0;
            }
            else{
                diskon = parseFloat($("#diskongrosir_1").val());
            } 
            
             $.post('<?php echo base_url(); ?>Employee/checkStock', {
                id: id_obat,
                stok : qty
            })
            .done(function(response) {
                if(response == "true"){
                    var harga_satuan = $('#hargasatuan_1').val();
                    var totalharga = qty*harga_satuan;
                    if(diskon < 0 && diskon >= 100 ){
                        diskon = 0;
                     }
                    var harga_satuan = $('#hargasatuan_1').val();
                    var totalharga = qty*harga_satuan;
                    
                    if(diskon != 0){
                        diskonku = totalharga * ((diskon)/100);
                        totalharga -= diskonku;
                    }
                    $("#totalharga_1").val(totalharga);
                    var totalall = 0;
                    for(var i=1;i<=numItems;i++){
                        if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                            totalall += 0;
                        }
                        else{
                            totalall += parseInt($("#totalharga_"+i).val(),0);
                        }
                    
                    }
                    $("#priceAll").val(totalall);
                }
                else{
                    var zero = 0;
                    var totalharga = 0;
                    swal("Stok Tidak Cukup !");
                    $("#qty_1").val(zero);
                    $("#totalharga_1").val(totalharga);
                    var totalall = 0;
                    for(var i=1;i<=numItems;i++){
                        if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                                    totalall += 0;
                                }
                                else{
                                totalall += parseInt($("#totalharga_"+i).val(),0);
                                }
                        
                    }
                    $("#priceAll").val(totalall);
                    
                }
            });
        });
    

        function add_item() {
            numItems++;
            numbering++;
            $('#item-container').append(`
                <tr>
                <td class="item-number">`+numbering+`</td>
                <td>
                    <input type="text" name="itemCode[]" id="id_obat_`+numItems+`" placeholder="Kode Barang" class="form-control">
                </td>
                <td>
                    <input type="text" name="itemName[]" id="nama_`+numItems+`" placeholder="Nama Barang" class="form-control">
                </td>
                <td>
                    <select name="satuan[]" class="form-control" id="satuan_`+numItems+`">
                        <option value="1">Satuan</option>
                        <option value="0">Box</option>
                    </select>
                    
                </td>
                <td>
                    <input type="text" name="qty[]" id="qty_`+numItems+`" placeholder="Qty" class="form-control">
                </td>
                <td>
                    <input type="text" name="batch[]" id="batch_`+numItems+`" placeholder="No Batch" class="form-control" disabled>
                </td>
                <td>
                    <input type="text" name="expired[]" id="expired_`+numItems+`" placeholder="Expired" class="form-control" disabled>
                </td>
                <td>
                    <div class="input-group m-b">
                        <!--  <span class="input-group-addon">Rp.</span>-->
                        <input type="text" placeholder="Harga Satuan" name="pricePerPiece[]" id="hargasatuan_`+numItems+`" class="form-control" disabled> 
                    </div>
                </td>
                <td>
                    <div class="input-group m-b">
                        
                        <input type="text" placeholder="Diskon Grosir" name="diskongrosir[]" id="diskongrosir_`+numItems+`" class="form-control"> 
                        <span class="input-group-addon">%</span>
                    </div>
                </td>
                <td>
                <div class="input-group m-b">
                        <!--<span class="input-group-addon">Rp.</span>-->
                        <input type="text" placeholder="Harga" name="item_budget_ceiling[]" id="totalharga_`+numItems+`" class="form-control" disabled> 
                    </div>
                </td>
                <td>
                    <button type="button" onclick="remove_item(this);" class="btn btn-danger btn-sm">
                        <i class="fa fa-close"></i>
                    </button>
                </td>
            </tr>
            `);

                $( "#id_obat_"+numItems ).autocomplete({
                    source: "<?php echo site_url('Employee/getMedicineIdbyCabang/?');?>"
                });

                $( "#nama_"+numItems).autocomplete({
                    source: "<?php echo site_url('Employee/getMedicineNamebyCabang/?');?>"
                });

                $( "#nama_"+numItems).change(function() {
                    var nama = $("#nama_"+numItems).val();
                    $.post('<?php echo base_url(); ?>Employee/getObatbyName', {
                        name: nama
                    })
                    .done(function(response) {
                        var obj = JSON.parse(response);
                        $("#id_obat_"+numItems).val(obj.id_obat);
                        $("#batch_"+numItems).val(obj.no_batch);
                        $("#expired_"+numItems).val(obj.expired_date);
                        $("#hargasatuan_"+numItems).val(obj.harga_satuan);
                        $("#qty_"+numItems).val(0);
                        $("#totalharga_"+numItems).val(0);
                        var totalall = 0;
                        for(var i=1;i<=numItems;i++){
                            if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                                totalall += 0;
                            }
                            else{
                            totalall += parseInt($("#totalharga_"+i).val(),0);
                            }
                            
                        }
                        $("#priceAll").val(totalall);
                    });
                });

                $( "#satuan_"+numItems).change(function() {
                    var nama = $("#nama_"+numItems).val();
                    var satuan = $("#satuan_"+numItems).val();
                    $.post('<?php echo base_url(); ?>Employee/getObatbyName', {
                        name: nama
                    })
                    .done(function(response) {
                        
                        var obj = JSON.parse(response);
                        if(satuan == 1){
                        $("#id_obat_"+numItems).val(obj.id_obat);
                        $("#batch_"+numItems).val(obj.no_batch);
                        $("#expired_"+numItems).val(obj.expired_date);
                        $("#hargasatuan_"+numItems).val(obj.harga_satuan);
                        $("#qty_"+numItems).val(0);
                        $("#totalharga_"+numItems).val(0);
                        var totalall = 0;
                        for(var i=1;i<=numItems;i++){
                            if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                                totalall += 0;
                            }
                            else{
                            totalall += parseInt($("#totalharga_"+i).val(),0);
                            }
                            
                        }
                        $("#priceAll").val(totalall);
                        }
                        if(satuan == 0){
                        $("#id_obat_"+numItems).val(obj.id_obat);
                        $("#batch_"+numItems).val(obj.no_batch);
                        $("#expired_"+numItems).val(obj.expired_date);
                        $("#hargasatuan_"+numItems).val(obj.hargaBox);
                        $("#qty_"+numItems).val(0);
                        $("#totalharga_"+numItems).val(0);
                        var totalall = 0;
                        for(var i=1;i<=numItems;i++){
                            if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                                totalall += 0;
                            }
                            else{
                            totalall += parseInt($("#totalharga_"+i).val(),0);
                            }
                            
                        }
                        $("#priceAll").val(totalall);
                        }
                    });
                });

                $( "#id_obat_"+numItems ).change(function() {
                    var id_obat = $("#id_obat_"+numItems).val();
                    $.post('<?php echo base_url(); ?>Employee/getObatbyId', {
                        id: id_obat
                    })
                    .done(function(response) {
                        var obj = JSON.parse(response);
                        $("#nama_"+numItems).val(obj.nama);
                        $("#batch_"+numItems).val(obj.no_batch);
                        $("#expired_"+numItems).val(obj.expired_date);
                        $("#hargasatuan_"+numItems).val(obj.harga_satuan);
                        $("#qty_"+numItems).val(0);
                        $("#totalharga_"+numItems).val(0);
                        var totalall = 0;
                        for(var i=1;i<=numItems;i++){
                            if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                                totalall += 0;
                            }
                            else{
                            totalall += parseInt($("#totalharga_"+i).val(),0);
                            }
                            
                        }
                        $("#priceAll").val(totalall);
                    });
                });
                $( "#qty_"+numItems ).change(function() {
                    var qty = $("#qty_"+numItems).val();
                    var id_obat = $("#id_obat_"+numItems).val();
                    var diskon;
                    if($("#diskongrosir_"+numItems).val().length == 0){
                        diskon = 0;
                    }
                    else{
                        diskon = parseFloat($("#diskongrosir_"+numItems).val());
                    } 
                    $.post('<?php echo base_url(); ?>Employee/checkStock', {
                        id: id_obat,
                        stok : qty
                    })
                    .done(function(response) {
                        if(response == "true"){
                            if(diskon < 0 && diskon >= 100 ){
                                diskon = 0;
                            }
                            var harga_satuan = $('#hargasatuan_'+numItems).val();
                            var totalharga = qty*harga_satuan;
                            
                            if(diskon != 0){
                                diskonku = totalharga * ((diskon)/100);
                                totalharga -= diskonku;
                            }
                            $("#totalharga_"+numItems).val(totalharga);
                            //
                            var totalall = 0;
                            for(var i=1;i<=numItems;i++){
                                if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                                    totalall += 0;
                                }
                                else{
                                totalall += parseInt($("#totalharga_"+i).val(),0);
                                }
                                
                            }
                            $("#priceAll").val(totalall);
                        }
                        else{
                            var zero = 0;
                            var totalharga = 0;
                            swal("Stok Tidak Cukup !");
                            $("#qty_"+numItems).val(zero);
                            $("#totalharga_"+numItems).val(totalharga);
                            var totalall = 0;
                            for(var i=1;i<=numItems;i++){
                                if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                                    totalall += 0;
                                }
                                else{
                                totalall += parseInt($("#totalharga_"+i).val(),0);
                                }
                                
                            }
                            $("#priceAll").val(totalall);
                            
                        }
                });
                    
                });

                $( "#diskongrosir_"+numItems ).change(function() {
                    var qty = $("#qty_"+numItems).val();
                    var id_obat = $("#id_obat_"+numItems).val();
                    var diskon;
                    if($("#diskongrosir_"+numItems).val().length == 0){
                        diskon = 0;
                    }
                    else{
                        diskon = parseFloat($("#diskongrosir_"+numItems).val());
                    } 
                    $.post('<?php echo base_url(); ?>Employee/checkStock', {
                        id: id_obat,
                        stok : qty
                    })
                    .done(function(response) {
                        if(response == "true"){
                            if(diskon < 0 && diskon >= 100 ){
                                diskon = 0;
                            }
                            var harga_satuan = $('#hargasatuan_'+numItems).val();
                            var totalharga = qty*harga_satuan;
                            
                            if(diskon != 0){
                                diskonku = totalharga * ((diskon)/100);
                                totalharga -= diskonku;
                            }
                            $("#totalharga_"+numItems).val(totalharga);
                            //
                            var totalall = 0;
                            for(var i=1;i<=numItems;i++){
                                if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                                    totalall += 0;
                                }
                                else{
                                totalall += parseInt($("#totalharga_"+i).val(),0);
                                }
                                
                            }
                            $("#priceAll").val(totalall);
                        }
                        else{
                            var zero = 0;
                            var totalharga = 0;
                            swal("Stok Tidak Cukup !");
                            $("#qty_"+numItems).val(zero);
                            $("#totalharga_"+numItems).val(totalharga);
                            var totalall = 0;
                            for(var i=1;i<=numItems;i++){
                                if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                                    totalall += 0;
                                }
                                else{
                                totalall += parseInt($("#totalharga_"+i).val(),0);
                                }
                                
                            }
                            $("#priceAll").val(totalall);
                            
                        }
                });
                    
                });

        }

        function remove_item(obj) {
            numbering--;
            $(obj).parent().parent().remove();
            re_numbering();
        }

        function re_numbering() {
            $('.item-number').each(function(index, itemNumber) {
                $(itemNumber).text(index + 1);
                var totalall = 0;
                    for(var i=1;i<=numItems;i++){
                        if(Number.isNaN(parseInt($("#totalharga_"+i).val(),0)) == true ){
                            totalall += 0;
                        }
                        else{
                        totalall += parseInt($("#totalharga_"+i).val(),0);
                        }
                        
                    }
                    $("#priceAll").val(totalall);
                
            });
        }
        
     
    </script>
    <script>
    $(".price-of-package-element").change(function () {
       
  
    if ($(this).is(':checked')) {
      $('.cekbox').after('<div id="idku"> <div class="hr-line-dashed"></div> <div class="form-group"><label class="col-lg-2 control-label">Uang Muka</label><div class="col-lg-10"><div class="input-group m-b"><span class="input-group-addon">Rp.</span><input type="text" placeholder="Uang Muka" name="uangMuka" class="form-control" ></div></div></div></div>'); // Append the div from out of the loop
    } else {
       if ($('#formku').has('#idku')) {
           $('#idku').remove();
       }
    }
});</script>
