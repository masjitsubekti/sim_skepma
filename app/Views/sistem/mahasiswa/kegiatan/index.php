<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="background-color:#0a85da !important; padding:0.75rem 1.25rem;">
                <span style="color:#ffffff; font-size:12pt;"><i class="fa fa-bars"></i><b> Kegiatan Mahasiswa</b></span>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row" style="padding-top:12px;">
                        <div class="col-md-6">
                            <a href="<?= site_url('kegiatan/pilih-kelompok') ?>" class="btn btn-success mr-1 mb-1" id="btn-add"> <b> <i class="fa fa-plus-circle"></i> &nbsp;Tambah</b></a>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="limit" id="limit">
                                <option value="10" selected>10 Baris</option>
                                <option value="25">25 Baris</option>
                                <option value="50">50 Baris</option>
                                <option value="100">100 Baris</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" id="cari" name="cari" class="form-control" placeholder="Cari . . .">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div id="list"></div>
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

<?= $this->endSection() ?>