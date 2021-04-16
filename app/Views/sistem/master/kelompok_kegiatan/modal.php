<div class="modal fade text-left" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="modal_title_add" style="display:none;"><i class="fa fa-align-justify"></i> Tambah Kelompok Kegiatan</h5>
                <h5 class="modal-title" id="modal_title_update" style="display:none;"><i class="fa fa-align-justify"></i> Edit Kelompok Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form">
            <div class="modal-body">
                <input type="hidden" name="modeform" id="modeform">
                <input type="hidden" name="id" id="id" value="<?php if(isset($data)){echo $data['id_kelompok_kegiatan'];} ?>">
                <div class="form-group">
                    <label for="nama_kelompok_kegiatan" class="form-label">Nama Kelompok Kegiatan <span style="color:red;">*</span></label>
                    <input class="form-control" id="nama_kelompok_kegiatan" name="nama_kelompok_kegiatan" type="text" placeholder="Nama Kelompok Kegiatan . . ." autocomplete="off" 
                        value="<?php if(isset($data)){echo $data['nama_kelompok_kegiatan'];} ?>"
                        required 
                    >
                </div>	
                <div class="form-group">
                    <label for="urutan" class="form-label">Urutan <span style="color:red;">*</span></label>
                    <input class="form-control" id="urutan" name="urutan" type="number" placeholder="Urutan . . ." autocomplete="off" 
                        value="<?php if(isset($data)){echo $data['urutan'];} ?>"
                        required 
                    >
                </div>
                <div class="form-group">
                    <label for="keterangan" class="form-label">Keterangan <span style="color:red;">*</span></label>
                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3" placeholder="Keterangan . . ." required><?php if(isset($data)){echo $data['keterangan'];} ?></textarea>		
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="background-color:#95a5a6;color:white;" data-dismiss="modal"><b>Batal</b></button>
                <button type="submit" class="btn btn-primary" style="background-color:#3498db;color:white;"><b>Simpan</b></button>
            </div>
			</form>
        </div>
    </div>
</div>
<script>
$('#form').submit(function (event) {
    event.preventDefault();
    Swal.fire({
        title: 'Simpan Kelompok Kegiatan',
        text: "Apakah Anda yakin menyimpan data ?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3498db',
        cancelButtonColor: '#95a5a6',
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.ajax({
                    url: '<?= site_url() ?>'+'/kelompok-kegiatan/save',
                    method: 'POST',
                    dataType: 'json',	
                    data: new FormData($('#form')[0]),
                    async: true,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.success == true) {
                            Toast.fire({
                                type: 'success',
                                title: data.message
                            });
                            $('#form-modal').modal('hide');
                            swal.hideLoading()
                            pageLoad(1);
                        } else {
                            Swal.fire({type: 'error',title: 'Oops...',text: data.message});
                        }
                    },
                    fail: function (event) {
                        alert(event);
                    }
                });
            });
        },
        allowOutsideClick: false
    });
    event.preventDefault();
});
</script>
