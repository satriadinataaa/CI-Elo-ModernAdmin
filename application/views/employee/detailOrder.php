<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Order TRX-<?= $data_order?></h2>
        <ol class="breadcrumb">
            <li>
            <a href="<?php echo base_url(); ?>Employee">Home</a>
            </li>
            <li class="active">
                <strong>Detail Data Order</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Detail Data Order</h5>
                </div>
                <div class="ibox-content">
                    <div style="margin-bottom:50px">
                <?= form_open_multipart('Employee/transaksiOnline', ['class' => 'form-horizontal ']) ?>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Nama Pembeli</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="Nama" name="name" class="form-control" id="name" disabled value="<?= $penjualan->nama_pembeli?>"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">No Hp</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="Nama" name="no_hp" class="form-control"  disabled value="<?= $penjualan->no_hp?>"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Tanggal Transaksi</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="Nama" name="date" class="form-control"  disabled value="<?= $penjualan->created_at?>"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Daftar Obat:</label>
                                    <div class="col-lg-10">
                                    <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Obat</th>
                                                    <th>Jumlah</th>
                                                    <th>Total Harga</th>
                                                    <th>Satuan</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $loop=1;?>
                                             <?php foreach ($barang_jual as $i => $b): ?> 
                                                <?php foreach ($b->obat as $ob => $obb): ?> 
                                                <tr>
                                                    <td><?= $loop ?></td>
                                                    <td><?= $obb->nama?></td>
                                                    <td><?= $b->qty?></td>
                                                
                                                    <td>Rp <?php echo str_replace(",", ".",number_format($b->harga))?></td>
                                                    <td><?php echo ($b->satuan == '1') ? "Satuan" : "Box"; ?></td>
                                                 
                                                </tr>
                                                <!-- <?php $loop++; endforeach; ?> -->
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Aksi</label>
                                    <div class="col-lg-10">
                                        <a href="" class="btn btn-primary">Proses Transaksi</a> 
                                        <button  id="swal-6" onclick="hapus('<?= $penjualan->id_penjualan ?>');" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus Transaksi</button> 
                                    </div>
                                </div>
                               
                            <?= form_close() ?>
                            </div>
                            
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        function hapus(id_penjualan) {
            swal({
                    title: 'Are you sure?',
                    text: '',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.post('<?php echo base_url(); ?>Employee/transaksiOnline', {
                                proses: true,
                                id_penjualan: id_penjualan
                            })
                            .done(function (response) {
                                swal('Penjualan berhasil Diproses', {
                                    icon: 'success',
                                });
                                // window.location.href = '<?= base_url('Employee/expiredMedicine') ?>';
                                location.reload();
                            });

                    } else {
                        swal('Bon Belum Dilunasi!');
                    }
                });
        }
    </script>