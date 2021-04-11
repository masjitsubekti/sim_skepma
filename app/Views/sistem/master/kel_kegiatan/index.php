<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Kelompok Kegiatan</h4>
            </div>
            <hr>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="javascript:;" class="btn btn-success mr-1 mb-1" id="btn-add"> <b> <i class="fa fa-plus-circle"></i> &nbsp;Tambah</b></a>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="limit" id="limit" onchange="pageLoad(1)">
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
        // $('#div_dimscreen').show();
        var id_th = $('#input_id_th').val();
        var column = $('#input_column').val();
        var sort = $('#input_sort').val();
        var limit = $('#limit').val();
        var cari = $('#cari').val();
        $.ajax({
            url: "<?php echo site_url('kelompok-kegiatan/read-data/') ?>" + i,
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
                // $('#div_dimscreen').fadeOut('slow');
                sort_finish(id_th,sort);
            }
        });
    }

    $("#btn-add").click(function() {
        $.ajax({
            url: "<?php echo site_url('kelompok-kegiatan/load-modal/') ?>",
            type: 'post',
            dataType: 'html',
            beforeSend: function() {},
            success: function(result) {
                $('#div_modal').html(result);
                $('#modal_title_add').show();
                $('#modeform').val('ADD');
                $('#form-modal').modal('show');
            }
        });
    });
</script>

<?= $this->endSection() ?>