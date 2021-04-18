<div class="modal fade text-left" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="modal_title_add" style="display:none;"><i class="fa fa-align-justify"></i> Tambah Detail Kegiatan</h5>
                <h5 class="modal-title" id="modal_title_update" style="display:none;"><i class="fa fa-align-justify"></i> Edit Detail Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form">
            <div class="modal-body">
                <input type="hidden" name="modeform" id="modeform">
                <input type="hidden" name="id_kegiatan" value="<?php if(isset($id_kegiatan)){echo $id_kegiatan;} ?>">
                <input type="hidden" name="id" id="id" value="<?php if(isset($data)){echo $data['id_detail_kegiatan'];} ?>">
                <input type="hidden" name="is_entry_kategori" id="is_entry_kategori" value="<?php if(isset($data)){echo $data['is_entry_kategori'];}else{echo 'false';} ?>">
                <div class="form-group">
                    <label for="kategori">Kategori <span style="color:red;">*</span></label>
                    <div id="box-select-kategori">
                        <select class="form-control select2" id="select_kategori" name="select_kategori" required>
                            <option value="">Pilih Kategori Kegiatan</option>
                            <?php foreach ($kategori as $k) { ?>
                                <option 
                                <?php
                                    if(isset($data)){
                                        if($data['id_kategori']==$k->id_kategori){
                                            echo 'selected ';
                                        }
                                    }
                                    ?>
                                value="<?=$k->id_kategori?>"> <?=$k->kategori?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div id="box-add-kategori" style="display: none;">
                        <input class="form-control" id="input_kategori" name="input_kategori" type="text" placeholder="Kategori . . ." autocomplete="off" 
                            value="<?php if(isset($data)){echo $data['kategori'];} ?>" 
                        >
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkEntryKategori" onclick="checkEntryManual()"
                            <?php
                                if(isset($data)){
                                    if($data['is_entry_kategori']=='true' || $data['is_entry_kategori']=='t'){
                                        echo 'checked ';
                                    }
                                }
                            ?>
                        >
                        <label class="form-check-label" for="checkEntryKategori">
                            Isi manual
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="deskripsi" class="form-label">Detail Deskripsi</label>
                    <input class="form-control" id="deskripsi" name="deskripsi" type="text" placeholder="Detail Deskripsi . . ." autocomplete="off" 
                        value="<?php if(isset($data)){echo $data['deskripsi'];} ?>"
                    >
                </div>
                <div class="form-group">
                    <label for="poin" class="form-label">Poin <span style="color:red;">*</span></label>
                    <input class="form-control" id="poin" name="poin" type="number" placeholder="Poin . . ." autocomplete="off" 
                        value="<?php if(isset($data)){echo $data['poin'];} ?>"
                        required 
                    >
                </div>
                <div class="form-group">
                    <label for="bukti_terkait" class="form-label">Bukti Terkait <span style="color:red;">*</span></label>
                    <input class="form-control" id="bukti_terkait" name="bukti_terkait" type="text" placeholder="Bukti terkait . . ." autocomplete="off" 
                        value="<?php if(isset($data)){echo $data['bukti_terkait'];} ?>"
                        required 
                    >
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
    checkEntryManual()

    $(".select2").select2({
        placeholder: "Kategori Kegiatan . . .",
        width: '100%',
        allowClear: true,
    });

    $('#form').submit(function (event) {
        var mode = $("#modeform").val();
        var title = "";
        var narasi = "";
        if(mode=='ADD'){
            title = "Simpan Detail Kegiatan";
            narasi = "Apakah Anda yakin menyimpan data ?";
        }else{
            title = "Edit Detail Kegiatan";
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
                        url: '<?= site_url() ?>'+'/kegiatan/save-detail',
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

    function checkEntryManual() {
        var checkBox = document.getElementById("checkEntryKategori");
        if (checkBox.checked == true){
            $('#box-add-kategori').show('slow');
            $('#box-select-kategori').hide('slow');
            $('#is_entry_kategori').val(true);
            document.getElementById("input_kategori").setAttribute("required", "");       
            document.getElementById("select_kategori").removeAttribute("required");
        } else {
            $('#box-add-kategori').hide('slow');
            $('#box-select-kategori').show('slow');
            $('#is_entry_kategori').val(false);
            document.getElementById("input_kategori").removeAttribute("required");
            document.getElementById("select_kategori").setAttribute("required", "");       
        }
    }
</script>
