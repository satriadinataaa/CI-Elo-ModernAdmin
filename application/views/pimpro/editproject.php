    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Input Program</h2>
           <ol class="breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>pimpro">Pimpinan Proyek</a>
                </li>
    
                <li class="active">
                    <strong>Input Program</strong>
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
                            <h5>Edit Program</h5>
                        </div>
                        <div class="ibox-content">
                            <?= form_open_multipart('pimpro/edit-project/' . $project_id, ['class' => 'form-horizontal']) ?>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Tipe Proyek</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="type_id" id="type_id">
                                            <?php foreach ($types as $type): ?>
                                                <option <?= $project->type_id == $type->id ? 'selected' : '' ?> value="<?= $type->id ?>"><?= $type->type ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <a class="help-block m-b-none" data-toggle="modal" class="btn btn-primary" style="color: blue" href="#modal-form">+ Tambah Tipe</a>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Nama Program</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="Nama Program" name="project_name" id="project_name" value="<?= $project->project_name ?>" class="form-control"> 
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Nilai Kontrak</label>
                                    <div class="col-lg-10">
                                        <div class="input-group m-b">
                                            <span class="input-group-addon">Rp.</span>
                                            <input type="text" placeholder="Nilai Kontrak" name="contract_value" id="contract_value" value="<?= $project->contract_value ?>" class="form-control"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Administrasi Keuangan</label>
                                    <div class="col-lg-10">
                                        <div class="input-group m-b">
                                            <span class="input-group-addon">Rp.</span>
                                            <input type="text" placeholder="Plafon Anggaran Administrasi Keuangan" name="financial_budget_ceiling" id="financial_budget_ceiling" value="<?= count($financial_items) > 0 ? $financial_items[0]->budget_ceiling : 0 ?>" class="form-control"> 
                                            <input type="hidden" name="financial_item_id" value="<?= count($financial_items) > 0 ? $financial_items[0]->id : 0 ?>">
                                        </div>
                                    </div>
                                </div>
                                 <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Item Proyek</label>
                                    <div class="col-lg-10">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama Item</th>
                                                    <th>Plafon Anggaran</th>
                                                    <th>-</th>
                                                </tr>
                                            </thead>
                                            <tbody id="item-container">
                                                
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-warning btn-sm" id="add-item-button" onclick="add_item();">
                                            <i class="fa fa-plus"></i> Tambah Item
                                        </button>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Nomor Kontrak</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="Nomor Kontrak" name="contract_number" id="contract_number" value="<?= $project->contract_number ?>" class="form-control"> 
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Tanggal Kontrak</label>
                                    <div class="input-group date col-lg-10">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control" name="contract_date" placeholder="yyyy-mm-dd" value="<?= $project->contract_date ?>" id="contract_date">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Penyedia Jasa</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="provider_id" id="provider_id">
                                            <?php foreach ($vendors as $vendor): ?>
                                                <option <?= $project->provider_id == $vendor->id ? 'selected' : '' ?> value="<?= $vendor->id ?>"><?= $vendor->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <a class="help-block m-b-none"  data-toggle="modal" class="btn btn-primary" style="color: blue" href="#modal-form2">+ Tambah Penyedia</a>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <input type="submit" name="submit" value="Edit Program" class="btn btn-success">
                                    </div>
                                    <div id="deleted-items-container"></div>
                                </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div id="modal-form" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <?= form_open_multipart('pimpro/edit-project/' . $project_id, ['class' => 'form-horizontal']) ?>
                            <h3 class="m-t-none m-b">Tambah Tipe Proyek</h3>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Nama Tipe Proyek</label>
                                <div class="col-lg-9">
                                    <input type="text" placeholder="Nama Tipe Proyek" id="type" name="type" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Keterangan</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" name="description" id="description" placeholder="Keterangan"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10 pull-right">
                                    <button type="button" onclick="add_project_type();" class="btn btn-sm btn-success" data-dismiss="modal">Tambah</button>
                                </div>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-form2" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <?= form_open_multipart('pimpro/edit-project/' . $project_id, ['class' => 'form-horizontal']) ?>
                            <h3 class="m-t-none m-b">Tambah Penyedia Jasa</h3>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Nama</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="Nama" name="name" id="sp_name" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Email</label>
                                <div class="col-lg-10">
                                    <input type="email" placeholder="Email" name="email" id="sp_email" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Kontak</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="Kontak" name="contact" id="sp_contact" class="form-control"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Username</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="Username" name="username" id="sp_username" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Password</label>
                                <div class="col-lg-10">
                                    <input type="password" placeholder="Password" name="password" id="sp_password" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Konfirmasi Password</label>
                                <div class="col-lg-10">
                                    <input type="password" placeholder="Konfirmasi Password" name="rpassword" id="sp_rpassword" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button type="button" onclick="add_service_provider();" class="btn btn-sm btn-success" data-dismiss="modal">Tambah</button>
                                </div>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        let numItems = 0;

        $(document).ready(function() {

            <?php foreach ($physical_items as $item): ?>
                retrieve_item('<?= $item->id ?>', '<?= $item->name ?>', '<?= $item->budget_ceiling ?>');
            <?php endforeach; ?>

        });

        function retrieve_item(id, name, budget) {
            numItems++;
            $('#item-container').append(`
                <tr>
                    <td class="item-number">` + numItems + `</td>
                    <td>
                        <input type="text" name="item_name[]" id="item_name_` + numItems + `" placeholder="Nama Item" value="` + name + `" class="form-control">
                    </td>
                    <td>
                        <div class="input-group m-b">
                            <span class="input-group-addon">Rp.</span>
                            <input type="text" placeholder="Plafon Anggaran" name="item_budget_ceiling[]" id="item_budget_ceiling_` + numItems + `" value="` + budget + `" class="form-control"> 
                        </div>
                    </td>
                    <td>
                        <button type="button" onclick="remove_item(this);" class="btn btn-danger btn-sm">
                            <i class="fa fa-close"></i>
                        </button>
                        <input type="hidden" name="old_physical_items_id[]" value="` + id + `"/>
                    </td>
                </tr>
            `);
        }

        function add_item() {
            numItems++;
            $('#item-container').append(`
                <tr>
                    <td class="item-number">` + numItems + `</td>
                    <td>
                        <input type="text" name="item_name[]" id="item_name_` + numItems + `" placeholder="Nama Item" class="form-control">
                    </td>
                    <td>
                        <div class="input-group m-b">
                            <span class="input-group-addon">Rp.</span>
                            <input type="text" placeholder="Plafon Anggaran" name="item_budget_ceiling[]" id="item_budget_ceiling_` + numItems + `" class="form-control"> 
                        </div>
                    </td>
                    <td>
                        <button type="button" onclick="remove_item(this);" class="btn btn-danger btn-sm">
                            <i class="fa fa-close"></i>
                        </button>
                    </td>
                </tr>
            `);
        }

        function remove_item(obj) {
            numItems--;
            $(obj).parent().parent().remove();
            const siblings = $(obj).siblings();
            if (siblings.length > 0) {
                const itemId = $(siblings[0]).val();
                $('#deleted-items-container').append('<input type="hidden" name="deleted_old_items_id[]" value="' + itemId + '"/>');
            }
            re_numbering();
        }

        function re_numbering() {
            $('.item-number').each(function(index, itemNumber) {
                $(itemNumber).text(index + 1);
            });
        }

        function add_project_type() {
            $.ajax({
                url: '<?= base_url('pimpro/edit-project/' . $project_id) ?>',
                type: 'POST',
                data: {
                    add_project_type: true,
                    type: $('#type').val(),
                    description: $('#description').val()
                },
                success: function(response) {
                    const json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $('#type_id').html('');
                        let html = '';
                        for (let i = 0; i < json.data.length; i++) {
                            html += '<option value="' + json.data[i].id + '">' + json.data[i].type + '</option>';
                        }

                        $('#type_id').html(html);
                    }
                    else {
                        alert(json.message);
                    }

                    
                },
                error: function(err) {
                    alert(JSON.stringify(err));
                }
            });
        }

        function add_service_provider() {
            $.ajax({
                url: '<?= base_url('pimpro/edit-project/' . $project_id) ?>',
                type: 'POST',
                data: {
                    add_service_provider: true,
                    username: $('#sp_username').val(),
                    password: $('#sp_password').val(),
                    rpassword: $('#sp_rpassword').val(),
                    email: $('#sp_email').val(),
                    contact: $('#sp_contact').val(),
                    name: $('#sp_name').val()
                },
                success: function(response) {
                    const json = $.parseJSON(response);
                    if (json.status === 'success') {
                        $('#provider_id').html('');
                        let html = '';
                        for (let i = 0; i < json.data.length; i++) {
                            html += '<option value="' + json.data[i].id + '">' + json.data[i].name + '</option>';
                        }

                        $('#provider_id').html(html);
                    }
                    else {
                        alert(json.message);
                    }

                    
                },
                error: function(err) {
                    alert(JSON.stringify(err));
                }
            });
        }
    </script>