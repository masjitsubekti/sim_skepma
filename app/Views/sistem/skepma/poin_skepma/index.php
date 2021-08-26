<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<style>
.t-biodata td {
  padding: 2px !important;
}
</style>
<div class="row" id="basic-table">
  <div class="col-12">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <button class="btn btn-success"><b><i class="fa fa-print"></i> &nbsp;Cetak</b></button>
          <div class="row" style="padding-top:12px;">
            <div class="col-md-12">
              <h6 class="text-center">BIRO ADMINISTRASI KEMAHASISWAAN</h6>
              <h6 class="text-center">INSTITUT TEKNOLOGI ADHI TAMA SURABAYA</h6>
              <br>
              <h6 class="text-center">Transkip Nilai</h6>
              <h6 class="text-center">Satuan Kegiatan Ekstra Kurikuler dan Prestasi Mahasiswa</h6>
              <h6 class="text-center">(SKEPMA)</h6>
              <br>
              <table class="t-biodata">
                <tr>
                  <td style="width:27%;">Nama Mahasiswa</td>
                  <td style="width:2%;">:</td>
                  <td style="width:65%;">Abdul Masjit Subekti</td>
                </tr>
                <tr>
                  <td>Nomor Pokok Mahasiswa</td>
                  <td>:</td>
                  <td>06.2019.1.07095</td>
                </tr>
                <tr>
                  <td>Jurusan</td>
                  <td>:</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>Fakultas</td>
                  <td>:</td>
                  <td>-</td>
                </tr>
              </table>
              <br>
              <table class="table table-bordered">
                <tr>
                  <th class="text-center">NO</th>
                  <th>KELOMPOK KEGIATAN (Attribut Softskills)</th>
                  <th class="text-center">NILAI AKUMULASI</th>
                  <th class="text-center">PREDIKAT</th>
                </tr>
                <?php 
                $no=0; 
                $jml=$data_skepma->getNumRows();
                $total=0;
                foreach ($data_skepma->getResult() as $row) { $no++ ?>
                <tr>
                  <td class="text-center" style="width:3%;"><?= $no; ?></td>
                  <td style="width:50%;"><b><?= $row->nama_kelompok_kegiatan; ?></b> (<i><?= $row->keterangan; ?></i>)
                  </td>
                  <td class="text-center" style="width:10%;"><?= $row->akumulasi_nilai; ?></td>
                  <?php if($no == 1){ ?>
                  <td class="text-center" style="width:10%;" rowspan="<?= $jml+1 ?>">
                    <?php 
                        if($row->akumulasi_nilai <= 120) {
                            echo 'KURANG';
                        }else if($row->akumulasi_nilai > 120 && $row->akumulasi_nilai <= 140) {
                            echo 'CUKUP';
                        }else if($row->akumulasi_nilai > 140 && $row->akumulasi_nilai <= 160) {
                            echo 'BAIK';
                        }else if($row->akumulasi_nilai > 160) {
                            echo 'SANGAT BAIK';
                        }else{
                            echo '-';
                        } 
                    ?>
                  </td>
                  <?php } ?>
                </tr>
                <?php 
                $total = $total + $row->akumulasi_nilai;
                } ?>
                <tr>
                  <td colspan="2" class="text-center"><b>Total</b></td>
                  <td class="text-center"><?= $total; ?></td>
                </tr>
              </table>
              <br>
              <table style="width:100%">
                <tr>
                  <td style="width:65%"></td>
                  <td style="width:35% text-align:right;">
                    <table style="width:100%">
                      <tr>
                        <td>Surabaya, .................................</td>
                      </tr>
                      <tr>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Kepala Biro Administrasi Kemahasiswaan</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- DATA SORT -->
<input type="hidden" name="input_id_th" id="input_id_th" value="#column_waktu">
<input type="hidden" name="input_column" id="input_column" value="created_at">
<input type="hidden" name="input_sort" id="input_sort" value="desc">
<div id="div_modal"></div>
<script>
$(document).ready(function() {
  // pageLoad(1)
});

$('#cari').on('keypress', function(e) {
  if (e.which == 13) {
    pageLoad(1);
  }
});

function pageLoad(i) {
  var id_th = $('#input_id_th').val();
  var column = $('#input_column').val();
  var sort = $('#input_sort').val();
  var limit = $('#limit').val();
  var cari = $('#cari').val();
  $.ajax({
    url: "<?php echo site_url('mhs/read-data/') ?>" + i,
    type: 'post',
    dataType: 'html',
    data: {
      limit: limit,
      cari: cari,
      column: column,
      sort: sort,
    },
    beforeSend: function() {},
    success: function(result) {
      $('#list').html(result);
      sort_finish(id_th, sort);
    }
  });
}
</script>

<?= $this->endSection() ?>