<div class="modal fade text-left" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="modal_title_add" style="display:none;"><i class="fa fa-align-justify"></i> Tambah User</h5>
                <h5 class="modal-title" id="modal_title_update" style="display:none;"><i class="fa fa-align-justify"></i> Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form">
            <div class="modal-body">
                <input type="hidden" name="modeform" id="modeform">
                <input type="hidden" name="id_user" id="id_user" value="<?php if(isset($data)){echo $data['id_user'];} ?>">
                <div class="form-group">
                    <label for="nama" class="form-label">Nama<span style="color:red;">*</span></label>
                    <input class="form-control" id="nama" name="nama" type="text" placeholder="Nama User . . ." autocomplete="off" 
                        value="<?php if(isset($data)){echo $data['nama'];} ?>"
                        required 
                    >
                </div>
                <div class="form-group">
                    <label for="nama" class="form-label">Username<span style="color:red;">*</span></label>
                    <input class="form-control" id="username" name="username" type="text" placeholder="Username . . ." autocomplete="off" 
                        value="<?php if(isset($data)){echo $data['username'];} ?>"
                        required 
                    >
                </div>
                <div class="form-group">
                    <label for="nama" class="form-label">Email</label>
                    <input class="form-control" id="email" name="email" type="text" placeholder="Email . . ." autocomplete="off" 
                        value="<?php if(isset($data)){echo $data['email'];} ?>"
                    >
                </div>
                <div class="form-group">
                    <label for="nama" class="form-label">Role<span style="color:red;">*</span></label>
                    <select class="form-control select2" id="role" name="role" required>
                        <option value="">Pilih Role</option>
                        <?php foreach ($role as $r) { ?>
                            <option 
                            <?php
                                if(isset($data)){
                                    if($data['id_role']==$r['id_role']){
                                        echo 'selected ';
                                    }
                                }
                            ?>
                            value="<?=$r['id_role']?>"> <?=$r['nama']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nama" class="form-label">Password
                      <?php if($mode=="ADD"){ ?>
                        <span style="color:red;">*</span>
                      <?php } ?>
                    </label>
                    <input class="form-control" id="password" name="password" type="text" placeholder="Password . . ." autocomplete="off" 
                        <?php if($mode=="ADD"){ echo 'required'; }?>
                    >
                    <?php if($mode=="UPDATE"){ ?>
                        <small>*Kosongkan password jika tidak ingin merubah password</small>
                    <?php } ?>
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
        title: 'Simpan User',
        text: "Apakah Anda yakin menyimpan data ?",
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
                    url: '<?= site_url() ?>'+'/user/save',
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
