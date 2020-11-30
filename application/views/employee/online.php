<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Transaksi Online</h2>
        <ol class="breadcrumb">
            <li>
            <a href="<?php echo base_url(); ?>Employee">Home</a>
            </li>
            <li class="active">
                <strong>Transaksi Online</strong>
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
                    <h5>Bon</h5>
                </div>
                <div class="ibox-content">

                    <table class="table table-bordered dataTables-example  ">
                        <thead>
                            <tr>
                                <th>Id Penjualan</th>
                                <th>Nama Pembeli</th>
                                <th>No Hp</th>
                                
                                <th>Total Pembelian</th>
                                <th>Tanggal Transaksi</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                           <!-- <?php foreach ($online as $i => $expired): ?> -->

                            <tr>
                                <td>TRX-<?= $expired->id_penjualan?></td>
                                <td><?= $expired->nama_pembeli?></td>
                                <td><?= $expired->no_hp?></td>
                               
                                <td>Rp <?php echo str_replace(",", ".",number_format($expired->total))?></td>
                                <td><?= $expired->created_at?></td>
                               
                                <td>
                                <!--    <a data-toggle="modal" class="btn btn-warning"
                                        onclick="document.getElementById('account_id').value = <?= $user->id_user ?>"
                                        id="toggle-change-password-<?= $user->username ?>" href="#modal-form2">Edit</a>
                                -->   
                                                   
                                    <a href="<?= base_url()?>Employee/detailOnline/<?= $expired->id_penjualan ?>"
                                        class="btn btn-warning"><i class="fa fa-check"></i>Proses</a>
                                    
                                </td> 
                            </tr>
                            <!-- <?php endforeach; ?> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        function prosesOnline(id_penjualan) {
            swal({
                    title: 'Are you sure?',
                    text: '',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willProcess) => {
                    if (willProcess) {
                        $.post('<?php echo base_url(); ?>Employee/prosesOnline', {
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