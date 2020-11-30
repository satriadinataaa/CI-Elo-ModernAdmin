    <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>Edit Realisasi Proyek</h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url('pimpro'); ?>">Home</a>
                    </li>
                    <li class="active">
                        <strong>Edit Realisasi Proyek</strong>
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
                        <h5>Edit Realisasi Proyek</h5>
                    </div>
                    <?= $this->session->flashdata('msg') ?>
                    <div class="ibox-content">
                         <?= form_open_multipart('pimpro/edit-realisasi?project_id=' . $project_id . '&month=' . $month . '&year=' . $year, ['class' => 'form-horizontal']) ?>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Tanggal Laporan</label>
                                <div class="input-group date col-lg-10">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" readonly name="" value="<?= date('F Y', strtotime($this->data['year'] . '-' . $this->data['month'] . '-01')) ?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Realisasi Keuangan</label>
                                <div class="col-lg-10">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Item</th>
                                                <th>Realisasi</th>
                                                <th>Target</th>
                                            </tr>
                                        </thead>
                                        <tbody id="item-container">
                                            <?php $i = 0; foreach ($financial_items as $item): ?>
                                                <tr>
                                                    <td class="item-number"><?= ++$i ?></td>
                                                    <td>
                                                        <?= $item->name ?>
                                                    </td>
                                                    <td>
                                                        <?php if (count($item->financial_histories) > 0): ?>
                                                            <input type="hidden" name="financial_histories_id_<?= $item->id ?>[]" value="<?= count($item->financial_histories) > 0 ? $item->financial_histories[0]->id : '' ?>">
                                                        <?php endif; ?>

                                                        <div class="input-group m-b">
                                                            <span class="input-group-addon">Rp.</span>
                                                            <input type="number" placeholder="Realisasi Anggaran" name="financial_realization_<?= $item->id ?>_<?= count($item->financial_histories) > 0 ? $item->financial_histories[0]->id : '' ?>" id="financial_realization" class="form-control" value="<?= count($item->financial_histories) >0 ? $item->financial_histories[0]->realization : '' ?>"> 
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group m-b">
                                                            <input type="number" placeholder="Target" name="financial_target_<?= $item->id ?>_<?= count($item->financial_histories) > 0 ? $item->financial_histories[0]->id : '' ?>" id="financial_target" class="form-control" value="<?= count($item->financial_histories) >0 ? $item->financial_histories[0]->target : '' ?>"> 
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php foreach ($physical_items as $item): ?>
                                                <tr>
                                                    <td class="item-number"><?= ++$i ?></td>
                                                    <td>
                                                        <?= $item->name ?>
                                                    </td>
                                                    <td>
                                                        <?php if (count($item->financial_histories) > 0): ?>
                                                            <input type="hidden" name="financial_histories_id_<?= $item->id ?>[]" value="<?= count($item->financial_histories) > 0 ? $item->financial_histories[0]->id : '' ?>">
                                                        <?php endif; ?>

                                                        <div class="input-group m-b">
                                                            <span class="input-group-addon">Rp.</span>
                                                            <input type="number" placeholder="Realisasi Anggaran" name="financial_realization_<?= $item->id ?>_<?= count($item->financial_histories) > 0 ? $item->financial_histories[0]->id : '' ?>" id="financial_realization" class="form-control" value="<?= count($item->financial_histories) > 0 ? $item->financial_histories[0]->realization : '' ?>"> 
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group m-b">
                                                            <input type="number" placeholder="Target" name="financial_target_<?= $item->id ?>_<?= count($item->financial_histories) > 0 ? $item->financial_histories[0]->id : '' ?>" id="financial_target" value="<?= count($item->financial_histories) > 0 ? $item->financial_histories[0]->target : '' ?>" class="form-control"> 
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Realisasi Fisik</label>
                                <div class="col-lg-10">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Item</th>
                                                <th>Rencana</th>
                                                <th>Realisasi</th>
                                                <th>Target</th>
                                            </tr>
                                        </thead>
                                        <tbody id="item-container">
                                            <?php $i = 0; foreach ($physical_items as $item): ?>
                                                <tr>
                                                    <td class="item-number"><?= ++$i ?></td>
                                                    <td>
                                                        <?= $item->name ?>
                                                    </td>
                                                    <td>
                                                        <?php if (count($item->physical_histories) > 0): ?>
                                                            <input type="hidden" name="physical_histories_id_<?= $item->id ?>[]" value="<?= count($item->physical_histories) > 0 ? $item->physical_histories[0]->id : '' ?>">
                                                        <?php endif; ?>

                                                        <div class="input-group m-b">
                                                            <input type="number" placeholder="Rencana" name="physical_planning_<?= $item->id ?>_<?= count($item->physical_histories) > 0 ? $item->physical_histories[0]->id : '' ?>" id="physical_planning" class="form-control" value="<?= count($item->physical_histories) >0 ? $item->physical_histories[0]->planning : '' ?>"> 
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group m-b">
                                                            <input type="number" placeholder="Realisasi" name="physical_realization_<?= $item->id ?>_<?= count($item->physical_histories) > 0 ? $item->physical_histories[0]->id : '' ?>" id="physical_realization" class="form-control" value="<?= count($item->physical_histories) >0 ? $item->physical_histories[0]->realization : '' ?>"> 
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group m-b">
                                                            <input type="number" placeholder="Target" name="physical_target_<?= $item->id ?>_<?= count($item->physical_histories) > 0 ? $item->physical_histories[0]->id : '' ?>" id="physical_target" class="form-control" value="<?= count($item->physical_histories) >0 ? $item->physical_histories[0]->target : '' ?>"> 
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input type="submit" name="submit" value="Edit" class="btn btn-sm btn-success">
                                </div>
                            </div>
                         <?= form_close() ?>
                     </div>
                 </div>
             </div>
         </div>