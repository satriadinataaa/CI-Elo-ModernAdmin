<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Pegawai</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>Owner">Home</a>
            </li>
            <li class="active">
                <strong>Pegawai</strong>
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
                    <h5>Tambah Pegawai</h5>
                </div>
                <div class="ibox-content">
                    <?= form_open_multipart('Owner/createEmployee', ['class' => 'form-horizontal']) ?>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Nama Pegawai</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Nama" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Telepon</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Telepon" name="telepon" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Cabang</label>

                        <div class="col-lg-10">

                            <select name="branch" class="form-control" required>
                                <option>Pilih Cabang</option>
                                <?php foreach ($cabang as $c => $cabang): ?>
                                <option value="<?= $cabang->id_cabang?>"><?= $cabang->nama_cabang ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Username</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Username" name="username" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Password</label>
                        <div class="col-lg-10">
                            <input type="password" placeholder="Password" name="password" class="form-control" required>
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
                    <h5>Pegawai</h5>
                </div>
                <div class="ibox-content">

                    <table class="table dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>Telepon</th>
                                <th>Cabang</th>
                                <th>Username</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user as $i => $user): ?>

                            <tr>
                                <td><?=$i+1?></td>
                                <td><?= $user->nama ?></td>
                                <td><?= $user->no_hp ?></td>
                                <td><?= $user->cabang->nama_cabang?></td>
                                <td><?= $user->username ?></td>
                                <td>
                                    <a data-toggle="modal" class="btn btn-warning"
                                        onclick="document.getElementById('account_id').value = <?= $user->id_user ?>"
                                        id="toggle-change-password-<?= $user->username ?>" href="#modal-form2">Edit</a>
                                    <!-- <a data-toggle="modal" class="btn btn-warning"  href="#modal-form2">Edit</a>-->
                                    <button id="swal-6" onclick="hapus('<?= $user->id_user ?>');"
                                        class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                                    <!-- <button  id="swal-6" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>-->
                                </td>
                            </tr>
                            <?php endforeach; ?>
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
                        <?= form_open_multipart('Owner/createEmployee', ['class' => 'form-horizontal']) ?>
                        <h3 class="m-t-none m-b">Edit Data</h3>
                        <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                                </div>
                            </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Cabang</label>
                            <div class="col-lg-10">
                                <select name="branch" class="form-control" required>
                                    <option>Pilih Cabang</option>
                                    <?php foreach ($cabang_modal as $c => $cabang): ?>
                                    <option value="<?= $cabang->id_cabang?>"><?= $cabang->nama_cabang ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="id_user" id="account_id">
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
        function hapus(id_user) {
            swal({
                    title: 'Are you sure?',
                    text: '',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.post('<?php echo base_url(); ?>Owner/createEmployee', {
                                delete: true,
                                id_user: id_user
                            })
                            .done(function (response) {
                                swal('Akun berhasil dihapus', {
                                    icon: 'success',
                                });
                                // window.location.href = '<?= base_url('Owner/createEmployee') ?>';
                                location.reload();
                            });

                    } else {
                        swal('Your imaginary file is safe!');
                    }
                });
        }
    </script>