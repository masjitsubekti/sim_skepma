<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="background-color:#0984e3 !important; padding:0.75rem 1.25rem;">
                <span style="color:#ffffff;"><i class="fa fa-bars"></i><b> Detail Kegiatan</b></span>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row" style="padding-top:12px;">
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
<input type="hidden" id="id_kegiatan" value="<?= $id_kegiatan ?>">
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
        var id_kegiatan = $('#id_kegiatan').val();
        $.ajax({
            url: "<?php echo site_url('kegiatan/read-data-detail/') ?>" + i,
            type: 'post',
            dataType: 'html',
            data: {
                limit: limit,
                cari: cari,
                column:column,
                sort:sort,
                id_kegiatan:id_kegiatan
            },
            beforeSend: function() {},
            success: function(result) {
                $('#list').html(result);
                sort_finish(id_th,sort);
            }
        });
    }

    $("#btn-add").click(function() {
        var id_kegiatan = $('#id_kegiatan').val();
        $.ajax({
            url: "<?php echo site_url('kegiatan/load-modal-detail') ?>",
            type: 'post',
            dataType: 'html',
            data: {
                id_kegiatan:id_kegiatan
            },
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