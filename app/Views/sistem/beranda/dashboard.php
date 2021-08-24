<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<section id="dashboard-analytics">
    <div id="data-dashboard"></div>
</section>
<script src="<?= base_url() ?>/all/Highcharts/code/highcharts.js"></script>
<script src="<?= base_url() ?>/all/Highcharts/code/modules/exporting.js"></script>
<script src="<?= base_url() ?>/all/Highcharts/code/modules/export-data.js"></script>
<script>
    $(document).ready(function() {
        loadDataDashboard()
    });

    function loadDataDashboard(){
      $.ajax({
          url: "<?= site_url('dashboard/admin')?>",
          type: 'post',
          dataType: 'html',
          data : {},
          beforeSend: function () {},
          success: function (result) {
              $('#data-dashboard').html(result);
          }
      });
    }
</script>
<?= $this->endSection() ?>