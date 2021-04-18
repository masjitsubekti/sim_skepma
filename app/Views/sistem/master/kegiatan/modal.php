<div class="modal fade text-left" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="modal_title_add" style="display:none;"><i class="fa fa-align-justify"></i> Tambah Kegiatan</h5>
                <h5 class="modal-title" id="modal_title_update" style="display:none;"><i class="fa fa-align-justify"></i> Edit Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form">
            <div class="modal-body">
                <input type="hidden" name="modeform" id="modeform">
                <input type="hidden" name="id" id="id" value="<?php if(isset($data)){echo $data['id_kegiatan'];} ?>">
                <div class="form-group">
                    <label for="nama_kelompok_kegiatan" class="form-label">Nama Kegiatan <span style="color:red;">*</span></label>
                    <input class="form-control" id="nama_kegiatan" name="nama_kegiatan" type="text" placeholder="Nama Kegiatan . . ." autocomplete="off" 
                        value="<?php if(isset($data)){echo $data['nama_kegiatan'];} ?>"
                        required 
                    >
                </div>
                <div class="form-group">
                    <label for="kelompok_kegiatan">Kelompok Kegiatan</label>
                    <select class="form-control select2" id="kelompok_kegiatan" name="kelompok_kegiatan" required>
                        <option value="">Pilih Kelompok Kegiatan</option>
                        <?php foreach ($kelompok_kegiatan as $k) { ?>
                            <option 
                            <?php
                                if(isset($data)){
                                    if($data['id_kelompok_kegiatan']==$k['id_kelompok_kegiatan']){
                                        echo 'selected ';
                                    }
                                }
                            ?>
                            value="<?=$k['id_kelompok_kegiatan']?>"> <?=$k['nama_kelompok_kegiatan']?></option>
                        <?php } ?>
                    </select>
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
    $(".select2").select2({
        placeholder: "Kelompok Kegiatan . . .",
        width: '100%',
        allowClear: true,
    });

    $('#form').submit(function (event) {
        var mode = $("#modeform").val();
        var title = "";
        var narasi = "";
        if(mode=='ADD'){
            title = "Simpan Kegiatan";
            narasi = "Apakah Anda yakin menyimpan data ?";
        }else{
            title = "Edit Kegiatan";
            narasi = "Apakah Anda yakin mengubah data ?";
        }

        event.preventDefault();
        Swal.fire({
            title: title,
            text: narasi,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#95a5a6',
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        url: '<?= site_url() ?>'+'/kegiatan/save',
                        method: 'POST',
                        dataType: 'json',	
                        data: new FormData($('#form')[0]),
                        async: true,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            if (data.success == true) {
                                Toast.fire({
                                    icon: 'success',
                                    title: data.message
                                });
                                $('#form-modal').modal('hide');
                                swal.hideLoading()
                                pageLoad(1);
                            } else {
                                Swal.fire({icon: 'error',title: 'Oops...',text: data.message});
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
