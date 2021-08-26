<style>
  .small-box {
    border-radius: 2px;
    position: relative;
    display: block;
    margin-bottom: 20px;
    box-shadow: 0 1px 1px rgb(0 0 0 / 10%);
    font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;;
  }
  .small-box>.inner {
    padding: 5px;
    padding-left : 10px;
  }
  .small-box .icon {
    -webkit-transition: all .3s linear;
    -o-transition: all .3s linear;
    transition: all .3s linear;
    position: absolute;
    top: -3px;
    right: 30px;
    z-index: 0;
    font-size: 70px;
    color: rgba(0,0,0,0.15);
  }
  .small-box>.small-box-footer {
    position: relative;
    text-align: right;
    padding: 3px 10px;
    color: #fff;
    color: rgba(255,255,255,0.8);
    display: block;
    /* z-index: 10; */
    background: rgba(0,0,0,0.1);
    text-decoration: none;
    font-size:14px;
  }
  .small-box h3 {
    font-size: 38px;
    font-weight: bold;
    /* margin: 0 0 10px 0; */
    white-space: nowrap;
    padding: 0;
    color:white;
  }
  .small-box p {
    font-size: 15px;
    color:white;
  }
  .bg-green{
    background-color : #00a65a !important
  }
  .bg-blue{
    background-color: #00c0ef !important;
  }
  .bg-yellow{
    background-color: #f39c12 !important;
  }
  .bg-red{
    background-color: #dd4b39 !important;
  }
  .d-icons{
    font-size:65px !important;
  }
</style>
<div class="media" style="background:#fff; padding:15px;">
    <div class="mr-2">
        <img src="<?= base_url('all/images/icon/user.png') ?>" height="70" width="70" alt="" class="avatar-md rounded-circle img-thumbnail">
    </div>
    <div class="media-body align-self-center">
        <div class="text-muted">
            <h5>Selamat Datang <?=  session()->get("auth_nama_user"); ?>.</h5>
            <p class="mb-0" style="color:#505050;">
              Aplikasi SKEPMA ini merupakan alat bantu dan media pencatatan kegiatan mahasiswa, silahkan pilih menu disamping untuk memulai.
            </p>
        </div>
    </div>
</div>
<br>
<div class="row">  
  <div class="col-md-3">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3><?= $dashboard['total_kegiatan'] ?></h3>
        <p>Total Kegiatan</p>
      </div>
      <div class="icon">
        <i class="fa fa-book"></i>
      </div>
      <a href="javascript:void(0)" class="small-box-footer">Lihat <i class="fa fa-arrow-right"></i> </a>
    </div>
  </div>
  <div class="col-md-3">
    <div class="small-box bg-green">
      <div class="inner">
        <h3><?= $dashboard['diverifikasi'] ?></h3>
        <p>Diverifikasi</p>
      </div>
      <div class="icon">
        <i class="fa fa-book"></i>
      </div>
      <a href="javascript:void(0)" class="small-box-footer">Lihat <i class="fa fa-arrow-right"></i> </a>
    </div>
  </div>
  <div class="col-md-3">
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3><?= $dashboard['proses_verifikasi'] ?></h3>
        <p>Proses Verifikasi</p>
      </div>
      <div class="icon">
        <i class="fa fa-book"></i>
      </div>
      <a href="javascript:void(0)" class="small-box-footer">Lihat <i class="fa fa-arrow-right"></i> </a>
    </div>
  </div>
  <div class="col-md-3">
    <div class="small-box bg-red">
      <div class="inner">
        <h3><?= $dashboard['jenis_kegiatan'] ?></h3>
        <p>Jenis Kegiatan</p>
      </div>
      <div class="icon">
        <i class="fa fa-book"></i>
      </div>
      <a href="javascript:void(0)" class="small-box-footer">Lihat <i class="fa fa-arrow-right"></i> </a>
    </div>
  </div>
</div>
<div class="row mt-1">
  <div class="col-md-12">
    <div class="card" style="box-shadow:none !important;">
      <div class="card-body">
        <div id="line-chart2"></div>
      </div>
    </div>
  </div>
</div>
<?php
  $db = Config\Database::connect();
?>
<script>
  Highcharts.chart('line-chart2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Chart Aktivitas Kegiatan Mahasiswa'
    },
    credits: {
      enabled: false
    },
    subtitle: {
        text: 'Tahun 2021'
    },
    xAxis: {
        categories: [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah Kegiatan'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">Bulan {point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    colors: [
      '#F7A35C',
      '#00ff00',
      '#8085E9',
    ],
    series: [
    <?php  
      foreach ($chart as $row) { ?>
      {
        name: '<?= $row['name']; ?>',
        data: [<?= implode(",", $row['data']); ?>]
      },
      <?php } ?>
    ]
});
</script>