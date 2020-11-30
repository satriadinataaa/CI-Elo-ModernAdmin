<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Data Kontrak</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url(); ?>home">Home</a>
                        </li>
                        <li class="active">
                            <strong>Data Kontrak</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
                 <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Data Kontrak</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <tr>
                                        <th  style="text-align: center;">No</th>
                                        <th  style="text-align: center;">Tipe Proyek</th>
                                        <th  style="text-align: center;">Nama Proyek</th>
                                        <th  style="text-align: center;">Nomor Kontrak</th>
                                        <th  style="text-align: center;">Tanggal Kontrak</th>
                                        <th  style="text-align: center;">Penyedia Jasa</th>
                                        <th  style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($projects as $i => $project): ?>
                                    <tr>
                                        <td  style="text-align: center;"><?= $i + 1 ?></td>
                                        <td  style="text-align: center;"><?= $project->type->type ?></td>
                                        <td  style="text-align: center;"><?= $project->project_name ?></td>
                                        <td  style="text-align: center;"><?= $project->contract_number ?></td>
                                        <td style="text-align: center;"><?= $project->contract_date ?></td>
                                        <td  style="text-align: center;"><?= $project->provider->name ?></td>
                                        <td  style="text-align: center;">
                                            <!-- <a class="btn btn-success" href="<?php echo base_url(); ?>pimpro/report/<?= $project->id ?>">Riwayat</a> -->
                                            <a class="btn btn-primary" href="<?= base_url('pimpro/input-realisasi/' . $project->id) ?>">Input Realisasi</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
            </div>
        </div>