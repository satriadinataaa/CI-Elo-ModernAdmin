<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Riwayat Laporan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>pimpro">Home</a>
            </li>
            <li class="active">
                <strong>Riwayat Laporan</strong>
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
                    <h5>Filter</h5>
                </div>
                <div class="ibox-content">
                    <?= form_open('pimpro/history', ['class' => 'form-horizontal']) ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Bulan</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="month">
                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?= $i ?>" <?= $i == $month ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tahun</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="year">
                                    <?php for ($i = date('Y'); $i >= 1900; $i--): ?>
                                        <option value="<?= $i ?>" <?= $i == $year ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-success" type="submit">Filter</button>
                            </div>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Data Laporan</h5>
                </div>
                <div class="ibox-content">
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th rowspan="3" style="text-align: center;">No</th>
                                    <th rowspan="3" style="text-align: center;">Tipe Proyek</th>
                                    <th rowspan="3" style="text-align: center;">Nama Proyek</th>
                                    <th rowspan="3" style="text-align: center;">Total Anggaran</th>
                                    <th rowspan="3" style="text-align: center;">Nomor Kontrak</th>
                                    <th rowspan="3" style="text-align: center;">Tanggal Kontrak</th>
                                    <th rowspan="3" style="text-align: center;">Nilai Kontrak</th>
                                    <th rowspan="3" style="text-align: center;">Penyedia Jasa</th>
                                    <th colspan="3" style="text-align: center;">Realisasi Keuangan</th>
                                    <th colspan="4" style="text-align: center;">Realisasi Fisik</th>
                                    <th rowspan="3" style="text-align: center;">Sisa Dana (Rp.)</th>
                                    <th rowspan="3" style="text-align: center;">Action</th>
                                </tr>
                                <tr>
                                    <th rowspan="2" style="text-align: center;">Target (%)</th>
                                    <th colspan="2" style="text-align: center;">Realisasi</th>
                                    <th rowspan="2" style="text-align: center;">Target Kinerja</th>
                                    <th rowspan="2" style="text-align: center;">Rencana (%)</th>
                                    <th rowspan="2" style="text-align: center;">Realisasi (%)</th>
                                    <th rowspan="2" style="text-align: center;">Deviasi (%)</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center;">(%)</th>
                                    <th style="text-align: center;">(Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projects as $i => $project): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= $project->type->type ?></td>
                                        <td>
                                            <strong><?= $project->project_name ?></strong>
                                            <br><br>
                                            <ul>
                                                <?php foreach ($project->items as $item): ?>
                                                    <li><?= $item->name ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <strong id="<?= $project->id ?>-total-anggaran">TOTAL ANGGARAN</strong>
                                            <br><br>
                                            <ul>
                                                <?php 
                                                    $total = 0; 
                                                    foreach ($project->items as $item): 
                                                ?>
                                                    <li><?= 'Rp. ' . number_format($item->budget_ceiling, 2, ',', '.') ?></li>
                                                <?php 
                                                    $total += $item->budget_ceiling; 
                                                    endforeach; 
                                                ?>
                                            </ul>
                                            <script type="text/javascript">
                                                document.getElementById('<?= $project->id ?>-total-anggaran').innerText = '<?= 'Rp. ' . number_format($total, 2, ',', '.') ?>';
                                            </script>
                                        </td>
                                        <td><?= $project->contract_number ?></td>
                                        <td><?= $project->contract_date ?></td>
                                        <td><?= 'Rp. ' . number_format($project->contract_value, 2, ',', '.') ?></td>
                                        <td><?= $project->provider->name ?></td>
                                        <td>
                                            <br><br><br><br>
                                            <ul>
                                                <?php foreach ($project->items as $item): ?>
                                                    <?php if (count($item->financial_histories) > 0): ?>
                                                        <li><?= $item->financial_histories[0]->target . '%' ?></li>
                                                    <?php else: ?>
                                                        <li>0%</li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <br><br><br><br>
                                            <ul>
                                                <?php foreach ($project->items as $item): ?>
                                                    <?php if (count($item->financial_histories) > 0): ?>
                                                        <li><?= round(($item->financial_histories[0]->realization / $item->budget_ceiling) * 100, 2) . '%' ?></li>
                                                    <?php else: ?>
                                                        <li>0%</li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <br><br><br><br>
                                            <ul>
                                                <?php foreach ($project->items as $item): ?>
                                                    <?php if (count($item->financial_histories) > 0): ?>
                                                        <li><?= 'Rp. ' . number_format($item->financial_histories[0]->realization, 2, ',', '.') ?></li>
                                                    <?php else: ?>
                                                        <li>Rp. 0</li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <br><br><br><br>
                                            <ul>
                                                <?php foreach ($project->items as $item): ?>
                                                    <?php if (count($item->physical_histories) > 0): ?>
                                                        <li><?= $item->physical_histories[0]->target . '%' ?></li>
                                                    <?php else: ?>
                                                        <li>-</li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <br><br><br><br>
                                            <ul>
                                                <?php foreach ($project->items as $item): ?>
                                                    <?php if (count($item->physical_histories) > 0): ?>
                                                        <li><?= $item->physical_histories[0]->planning . '%' ?></li>
                                                    <?php else: ?>
                                                        <li>-</li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <br><br><br><br>
                                            <ul>
                                                <?php foreach ($project->items as $item): ?>
                                                    <?php if (count($item->physical_histories) > 0): ?>
                                                        <li><?= $item->physical_histories[0]->realization . '%' ?></li>
                                                    <?php else: ?>
                                                        <li>-</li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <br><br><br><br>
                                            <ul>
                                                <?php foreach ($project->items as $item): ?>
                                                    <?php if (count($item->physical_histories) > 0): ?>
                                                        <li><?= ($item->physical_histories[0]->realization - $item->physical_histories[0]->planning) . '%' ?></li>
                                                    <?php else: ?>
                                                        <li>-</li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <br><br><br><br>
                                            <ul>
                                                <?php foreach ($project->items as $item): ?>
                                                    <li><?= 'Rp. ' . number_format($item->budget_ceiling - (count($item->financial_histories) > 0 ? $item->financial_histories[0]->realization : 0), 2, ',', '.') ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('pimpro/edit-realisasi?project_id=' . $project->id . '&month=' . $month . '&year=' . $year) ?>" class="btn btn-warning"><i class="fa fa-pencil"></i> Edit</a>
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