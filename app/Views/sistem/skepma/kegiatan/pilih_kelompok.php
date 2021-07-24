<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<section id="knowledge-base-content">
    <div class="row search-content-info">
        <?php foreach ($kelompok_kegiatan as $row) { ?>
            <div class="col-md-4 col-sm-6 col-12 search-content">
                <div class="card" style="height: 350px;">
                    <div class="card-body text-center">
                        <a href="<?= site_url('mhs/input-kegiatan/'.$row['id_kelompok_kegiatan']) ?>">
                            <img src="<?php echo base_url() ?>/themes/app-assets/images/pages/graphic-2.png" class="mx-auto mb-2" width="180" alt="knowledge-base-image">
                            <h4><?= $row['nama_kelompok_kegiatan'] ?></h4>
                            <small class="text-dark"><?= $row['keterangan'] ?></small>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
<?= $this->endSection() ?>