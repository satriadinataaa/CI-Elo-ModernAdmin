<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Obat Expired</h2>
        <ol class="breadcrumb">
            <li>
            <a href="<?php echo base_url(); ?>Employee">Home</a>
            </li>
            <li class="active">
                <strong>Obat Expired</strong>
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
                    <h5>Obat Expired</h5>
                </div>
                <div class="ibox-content">

                    <table class="table dataTables-example">
                        <thead>
                            <tr>
                                <th>Id Obat</th>
                                <th>Nama Obat</th>
                                <th>Batch</th>
                                <th>Expired</th>
                                <th>Letak Obat</th>
                                <th>Qty</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                           <!-- <?php foreach ($expired as $i => $expired): ?> -->

                            <tr>
                                <td><?= $expired->id_obat?></td>
                                <td><?= $expired->nama?></td>
                                <td><?= $expired->no_batch?></td>
                                <td><?= $expired->expired_date ?></td>
                                <td><?= $expired->LetakObat?></td>
                                <td><?= $expired->stok?></td>
                                <td>
                                <!--    <a data-toggle="modal" class="btn btn-warning"
                                        onclick="document.getElementById('account_id').value = <?= $user->id_user ?>"
                                        id="toggle-change-password-<?= $user->username ?>" href="#modal-form2">Edit</a>
                                -->   
                                                   
                                    <button id="swal-6" onclick="hapus('<?= $expired->id_obat ?>');"
                                        class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                                    
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
        function hapus(id_obat) {
            swal({
                    title: 'Are you sure?',
                    text: '',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.post('<?php echo base_url(); ?>Owner/expiredMedicine', {
                                delete: true,
                                id_obat: id_obat
                            })
                            .done(function (response) {
                                swal('Obat berhasil dihapus', {
                                    icon: 'success',
                                });
                                // window.location.href = '<?= base_url('Owner/expiredMedicine') ?>';
                                location.reload();
                            });

                    } else {
                        swal('Your Medicine is safe!');
                    }
                });
        }
    </script>