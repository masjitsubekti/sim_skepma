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
                        <div class="col-md-2">
                            <select class="form-control" name="limit" id="limit">
                                <option value="10" selected>10 Baris</option>
                                <option value="25">25 Baris</option>
                                <option value="50">50 Baris</option>
                                <option value="100">100 Baris</option>
                            </select>
                        </div>
                        <div class="col-md-6"></div>
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
<script>
    $(document).ready(function() {
        pageLoad(1)
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
            url: "<?php echo site_url('dosen/read-data-kegiatan/') ?>" + i,
            type: 'post',
            dataType: 'html',
            data: {
                limit: limit,
                cari: cari,
                column:column,
                sort:sort,
            },
            beforeSend: function() {},
            success: function(result) {
                $('#list').html(result);
                sort_finish(id_th,sort);
            }
        });
    }
</script>

<?= $this->endSection() ?>