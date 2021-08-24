<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<section id="dashboard-analytics">
    <div id="data-dashboard"></div>
</section>
<script>
    $(document).ready(function() {
        loadDataDashboard()
    });

    function loadDataDashboard(){
      $.ajax({
          url: "<?= site_url('dashboard/status-kegiatan')?>",
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