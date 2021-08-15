<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<style>
  .date-picker {z-index:1200 !important;}
</style>
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="background-color:#7E74FC !important; padding:0.75rem 1.25rem;">
                <span style="color:#ffffff;"><i class="fa fa-bars"></i><b> Laporan Kegiatan</b></span>
            </div>
            <div class="card-content">
                <div class="card-body">
                  
                  <div class="row">
                      <div class="col-md-2">
                        Jenis Laporan
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <select class="form-control" name="jenis_laporan" id="jenis_laporan">
                            <option value="1">Laporan SKEPMA</option>
                            <option value="2">Laporan Rekap Kegiatan</option>
                          </select>
                        </div>
                      </div>
                  </div>
                  <hr style="margin-top:0px !important;">
                  <p>Periode</p>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-check">
                        <input class="form-check-input check-mode" type="radio" name="mode" id="mode_pertanggal" value="by_tanggal">
                        <label class="form-check-label" for="mode_pertanggal">
                          Pertanggal : 
                        </label>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" id="tgl_awal" name="tgl_awal" class="form-control date-picker" data-date-format='dd-mm-yyyy' placeholder="Tanggal Awal . . ." autocomplete="off" onkeypress="return false;" readonly>
                                </div>
                                <div class="col-md-2" style="text-align: center; padding-left:0px; padding-right:0px;">
                                    <span>s/d</span>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" id="tgl_akhir" name="tgl_akhir" class="form-control date-picker" data-date-format='dd-mm-yyyy' placeholder="Tanggal Akhir . . ." autocomplete="off" onkeypress="return false;" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-check">
                        <input class="form-check-input check-mode" type="radio" name="mode" id="mode_perbulan" value="by_bulan">
                        <label class="form-check-label" for="mode_perbulan">
                          Perbulan : 
                        </label>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="controls">
                                  <select class="form-control" id="bulan" name="bulan" required>
                                    <option value="">Pilih Bulan</option>
                                    <?php 
                                    $bulan = date('m');
                                    $array_bulan=array(
                                        '01'=>'Januari',
                                        '02'=>'Februari',
                                        '03'=>'Maret',
                                        '04'=>'April',
                                        '05'=>'Mei',
                                        '06'=>'Juni',
                                        '07'=>'Juli',
                                        '08'=>'Agustus',
                                        '09'=>'September',
                                        '10'=>'Oktober',
                                        '11'=>'November',
                                        '12'=>'Desember'
                                    );
                                    foreach ($array_bulan as $key => $value) { ?>
                                        <option 
                                        <?php if($bulan==$key){
                                            echo " selected";
                                        } ?> 
                                        value="<?= $key ?>"><?= $value ?></option>    
                                    <?php } ?>
                                  </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="controls">
                                  <input type="text" id="tahun" name="tahun" class="form-control date-picker"  data-date-min-view-mode="2"  data-date-format='yyyy' placeholder="Tahun . . ." data-provide="datepicker" onkeypress="return false;" readonly>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-check">
                        <input class="form-check-input check-mode" type="radio" name="mode" id="mode_pertahun" value="by_tahun">
                        <label class="form-check-label" for="mode_pertahun">
                          Pertahun : 
                        </label>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="controls">
                                <input type="text" id="tahunan" name="tahunan" class="form-control date-picker"  data-date-min-view-mode="2"  data-date-format='yyyy' placeholder="Tahun . . ." data-provide="datepicker" onkeypress="return false;" readonly>
                            </div>
                        </div>
                    </div>
                  </div>
                  <hr>
                  <button class="btn btn-success" onclick="export_laporan()"><i class="fa fa-file-excel-o"></i> Export Excel</button>
                  <button class="btn btn-warning" onclick="reset()"><i class="fa fa-refresh"></i> Reset</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="div_modal"></div>
<script>
  $('.date-picker').datepicker({
      autoclose: true,
      orientation: "bottom"
  })
  $('.date-picker').datepicker('setDate', new Date());

  function export_laporan(){
     var periode = $('.check-mode:checked').val();
     var tahun = $('#tahun').val();
     const bulan = $('#bulan').val();
     const tahunan = $('#tahunan').val();
    if(periode!==undefined){
        tahun = (periode == 'by_tahun') ? tahunan : tahun;
        var rentangTanggal = getTanggal(periode, bulan, tahun);
        if(rentangTanggal.success===true){
            window.location.href = "<?= site_url('report/laporan-skepma') ?>"+"?tgl_awal="+ rentangTanggal.tglAwal +"&tgl_akhir="+ rentangTanggal.tglAkhir;
        }else{
            console.log("Filter harus diisi")   
        }
    }else{
       console.log("cek periode", periode)
    }
  }

  function reset(){
    $('.date-picker').datepicker('setDate', new Date());    
  }

  function getTanggal (periode, bulan, tahun) {
      var tgl_awal = $('#tgl_awal').val();
      var tgl_akhir = $('#tgl_akhir').val();
      if (periode == undefined) {
        return {
          success: false,
          tglAwal: '',
          tglAkhir: '',
        }
      } else {
        var parseDate = ''
        if (periode == 'by_tahun') {
          parseDate = tahun + '-12-01'
        } else if (periode == 'by_bulan') {
          parseDate = tahun + '-' + bulan + '-01'
        } else {
          parseDate = ''
        }

        if (periode == 'by_tanggal') {
          var firstDay = tgl_awal
          var lastDay = tgl_akhir
        } else {
          var date = new Date(parseDate)
          var firstDay = periode == 'by_tahun' ? new Date(tahun + '-01-01') : new Date(date.getFullYear(), date.getMonth(), 2)
          var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 1)

          firstDay = firstDay.toISOString().substr(0, 10)
          lastDay = lastDay.toISOString().substr(0, 10)
        }

        return {
          success: true,
          tglAwal: firstDay,
          tglAkhir: lastDay,
        }
      }
    }
</script>
<?= $this->endSection() ?>