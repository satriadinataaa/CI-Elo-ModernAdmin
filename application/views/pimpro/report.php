<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Laporan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
            <li class="active">
                <strong>Laporan</strong>
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
                    <h5>Laporan Bulanan</h5>
                </div>
                <div class="ibox-content">
                     <form method="get" class="form-horizontal">
                         <div class="form-group"><label class="col-sm-2 control-label">Nama Program</label>
                            <div class="col-sm-10"><input type="text" value="<?= $project->name ?>" class="form-control" disabled=""></div>
                        </div>
                         <div class="hr-line-dashed"></div>
                          <div class="form-group"><label class="col-sm-2 control-label">Bulan</label>

                            <div class="col-sm-10">
                                <select class="form-control" name="account">
                                <option>option 1</option>
                                <option>option 2</option>
                                <option>option 3</option>
                            </select>
                        </div>
                        </div>
                          <div class="form-group"><label class="col-sm-2 control-label">Tahun</label>

                            <div class="col-sm-10">
                                <select class="form-control" name="account">
                                <option>option 1</option>
                                <option>option 2</option>
                                <option>option 3</option>
                            </select>
                        </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button class="btn btn-sm btn-success" type="submit">Check</button>
                            </div>
                        </div>
                     </form>
                 </div>
             </div>
            <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Laporan</h5>
            </div>
            <div class="ibox-content">
                  <form method="get" class="form-horizontal">
                          <div class="form-group"><label class="col-sm-2 control-label">Nama Program</label>
                            <div class="col-sm-10"><input type="text" class="form-control" disabled=""></div>
                        </div>
                         <div class="hr-line-dashed"></div>
                          <div class="form-group"><label class="col-sm-2 control-label">Total Anggaran</label>
                             <div class="input-group m-b"><span class="input-group-addon">Rp.</span> <input type="number" class="form-control" disabled=""></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label">Administrasi Keuangan</label>
                          <div class="input-group m-b"><span class="input-group-addon">Rp.</span> <input type="number" class="form-control" disabled=""></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label">Anggaran Program</label>
                          <div class="input-group m-b"><span class="input-group-addon">Rp.</span> <input type="number" class="form-control" disabled=""></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                          <div class="form-group"><label class="col-sm-2 control-label">Nomor Kontrak</label>
                            <div class="col-sm-10"><input type="text" class="form-control" disabled=""></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                          <div class="form-group" id="data_1"><label class="col-sm-2 control-label">Tanggal Kontrak</label>
                            <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014" disabled="">
                        </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                          <div class="form-group"><label class="col-sm-2 control-label">Nilai Kontrak</label>
                            <div class="input-group m-b"><span class="input-group-addon">Rp.</span> <input type="number" class="form-control" disabled=""></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                          <div class="form-group"><label class="col-sm-2 control-label">Penyedia Jasa</label>

                            <div class="col-sm-10">
                                <select class="form-control" name="account" disabled="">
                                <option>option 1</option>
                                <option>option 2</option>
                                <option>option 3</option>
                            </select>
                        </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <h5><strong>Realisasi Keuangan </strong></h5>
                          <div class="form-group"><label class="col-sm-2 control-label">Target</label>
                            <div class="input-group m-b"><input type="number" class="form-control" disabled=""> <span class="input-group-addon">%</span></div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Bulan ini (%)</label>
                            <div class="input-group m-b"><input type="number" class="form-control"> <span class="input-group-addon">%</span></div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Bulan ini (Rp.)</label>
                           <div class="input-group m-b"><span class="input-group-addon">Rp.</span> <input type="number" class="form-control"></div>
                        </div>
                         <div class="hr-line-dashed"></div>
                        <h5><strong>Realisasi Fisik </strong></h5>
                          <div class="form-group"><label class="col-sm-2 control-label">Target Kinerja</label>
                            <div class="input-group m-b"><input type="number" class="form-control" disabled=""> <span class="input-group-addon">%</span></div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Rencana (%)</label>
                            <div class="input-group m-b"><input type="number" class="form-control"> <span class="input-group-addon">%</span></div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Realisasi (%)</label>
                            <div class="input-group m-b"><input type="number" class="form-control"> <span class="input-group-addon">%</span></div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Deviasi (%)</label>
                            <div class="input-group m-b"><input type="number" class="form-control"> <span class="input-group-addon">%</span></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label">Sisa Dana (Rp.)</label>
                            <div class="input-group m-b"><span class="input-group-addon">Rp.</span> <input type="number" class="form-control"></div>
                        </div>
                         <div class="hr-line-dashed"></div>
                         <div class="form-group">
                            <div class="col-lg-offset-2">
                                <button class="btn btn-sm btn-success" type="submit">Laporan</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>

         </div>
    </div>