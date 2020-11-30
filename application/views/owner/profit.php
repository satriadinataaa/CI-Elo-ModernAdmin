<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Keuntungan</h2>
        <ol class="breadcrumb">
            <li>
            <a href="<?php echo base_url(); ?>Owner">Home</a>
            </li>
            <li class="active">
                <strong>Keuntungan</strong>
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
                    <?= form_open('Owner/allProfit', ['class' => 'form-horizontal']) ?>
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
                            <input class="btn btn-sm btn-success" type="submit" name="submit" Value="Filter" >
                            <!-- <a href="<?= base_url('home/export?month=' . $month . '&year=' . $year) ?>"
                                class="btn btn-sm btn-primary" type="button">Download Laporan</a>
                        </div> -->
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Data Laporan <?php if(isset($bulan)) { ?> Bulan ke <?= $bulan; }?>  <?php if(isset($tahun)) { ?> Tahun <?= $tahun; }?></h5>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Cabang</th>
                                    <th>No. Telepon</th>
                                    <th>Pegawai</th>
                                    <th>Total</th>
                                    <!--<th>Detail</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php $loop = 0;?>
                           <?php if(isset($laporan)){
                            foreach ($laporan as $i => $l): ?>
                                <tr>
                                    <td><?= $i+1?></td>
                                    <td><?= $l->nama_cabang?></td>
                                    <td><?= $l->no_hp ?></td>
                                    <td><?php foreach($l->user as $i => $u):?>
                                        <li><?=$u->nama?></li>
                                    <?php endforeach;?>
                                    </td>

                                    <td>Rp <?php echo str_replace(",", ".",number_format($total[$loop]))?></td>
                                   <!-- <td><a class="btn btn-primary">Detail</a></td>-->
                                </tr>
                                    
                               <?php $loop++;endforeach;}?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>