<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Cabang</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>Owner">Home</a>
            </li>
            <li class="active">
                <strong>Cabang</strong>
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
                    <h5>Tambah Cabang</h5>
                </div>
                <div class="ibox-content">
                    <?= form_open_multipart('Owner/createBranch', ['class' => 'form-horizontal']) ?>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Nama Cabang</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Nama" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Alamat</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Alamat" name="address" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Telepon</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Telepon" name="telepon" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <input type="submit" name="submit" value="Tambah" class="btn btn-sm btn-success">
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Cabang</h5>
                </div>
                <div class="ibox-content">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Cabang</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--<?php foreach ($cabang as $i => $cabang): ?>  -->
                            <tr>
                                <td><?= $i+1 ?></td>
                                <td><?= $cabang->nama_cabang?></td>
                                <td><?= $cabang->alamat?></td>
                                <td><?= $cabang->no_hp?></td>
                                <td>
                                    <a data-toggle="modal" class="btn btn-warning"
                                        onclick="document.getElementById('id_cabang').value = <?= $cabang->id_cabang ?>"
                                        id="toggle-change-password-<?= $cabang->username ?>"
                                        href="#modal-form2">Edit</a>
                                    <!--<a data-toggle="modal" class="btn btn-warning"  href="#modal-form2">Edit</a>-->
                                    <button id="swal-6" onclick="hapus(<?= $cabang->id_cabang ?>);"
                                        class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                                    <!-- <button  id="swal-6" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button> -->
                                </td>
                            </tr>
                            <!-- <?php endforeach; ?> -->

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>


    <div id="modal-form2" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <?= form_open_multipart('Owner/createBranch', ['class' => 'form-horizontal']) ?>
                        <h3 class="m-t-none m-b">Edit Cabang</h3>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nama Cabang</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="Nama Cabang" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Alamat</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="Alamat" name="address" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Telepon</label>
                            <div class="col-lg-10">
                                <input type="text" placeholder="No Telepon" name="telepon" class="form-control">
                            </div>
                        </div>
                        <input type="hidden" name="id_cabang" id="id_cabang">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input type="submit" name="edit" value="Ubah" class="btn btn-sm btn-success">
                            </div>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function hapus(id_cabang) {
            swal({
                    title: 'Are you sure?',
                    text: '',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })

                .then((willDelete) => {
                    if (willDelete) {

                        $.post('<?php echo base_url(); ?>Owner/createBranch', {
                                delete: true,
                                id_cabang: id_cabang
                            })
                            .done(function (response) {
                                swal('Akun berhasil dihapus', {
                                    icon: 'success',
                                });
                                // window.location.href = '<?= base_url('Owner/createBranch') ?>';
                                location.reload();
                            });

                    } else {
                        swal('Your imaginary file is safe!');
                    }
                });
        }
    </script>