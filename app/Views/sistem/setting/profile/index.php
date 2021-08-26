<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<section class="users-edit">
  <div class="row">
    <div class="col-12 col-sm-4">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <div class="media">
              <a class="mr-2 my-25" href="#">
                <img style="border:1px solid #ddd; padding:2px;" src="<?= base_url('all/images/icon/user.png') ?>" alt="users avatar" class="users-avatar-shadow rounded" height="60" width="60">
              </a>
              <div class="media-body mt-50">
                <h5 class="media-heading"><?= $data_user['nama'] ?></h5>
                <div class="col-12 d-flex px-0">
                  <span><?= session()->get('auth_nama_role') ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-8">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <ul class="nav nav-tabs mb-3" role="tablist">
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center active" id="account-tab" data-toggle="tab" href="#account"
                  aria-controls="account" role="tab" aria-selected="true">
                  <i class="feather icon-user mr-25"></i><span class="d-none d-sm-block">Akun User</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link d-flex align-items-center" id="information-tab" data-toggle="tab" href="#information"
                  aria-controls="information" role="tab" aria-selected="false">
                  <i class="feather icon-unlock mr-25"></i><span class="d-none d-sm-block">Ubah Password</span>
                </a>
              </li>
            </ul>
            <div class="tab-content">
              <input type="hidden" id="id_user" name="id_user" value="<?= $data_user['id_user'] ?>">
              <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                <form id="form-profile">
                  <div class="row">
                    <div class="col-12 col-sm-12">
                      <div class="form-group">
                        <div class="controls">
                          <label>Nama</label>
                          <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama . . ." value="<?= $data_user['nama'] ?>" autocomplete="off" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="controls">
                          <label>Email</label>
                          <input type="email" class="form-control" name="email" id="email" placeholder="Email . . ." value="<?= $data_user['email'] ?>" autocomplete="off" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                      <button type="submit" class="btn btn-primary glow mb-1 mb-sm-0 mr-0">Simpan</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane" id="information" aria-labelledby="information-tab" role="tabpanel">
                <form id="form-password">
                  <div class="row">
                    <div class="col-12 col-sm-12">
                      <div class="form-group">
                        <div class="controls">
                          <label>Password Baru</label>
                          <input type="password" class="form-control" name="password_baru" id="password_baru" placeholder="Password Baru . . ." autocomplete="off" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="controls">
                          <label>Konfirmasi Password</label>
                          <input type="password" class="form-control" name="konfirmasi_password" id="konfirmasi_password" onkeyup="validate_password()" placeholder="Konfirmasi Password . . ." autocomplete="off" required>
                        </div>
                        <span id="pass-message" style="font-size:12px;"></span>
                      </div>
                    </div>
                    <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                      <button type="submit" id="submit-reset" class="btn btn-primary glow mb-1 mb-sm-0 mr-0">Simpan</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
 $('#form-profile').submit(function (event) {
		event.preventDefault();
    const id_user = $('#id_user').val();
    let formData = new FormData($('#form-profile')[0]);
    formData.append("id_user", id_user);

		Swal.fire({
			title: 'Ubah Profile',
			text: "Apakah Anda yakin mengubah profile !",
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
						url: '<?= site_url() ?>'+'/user/update-profile',
						method: 'POST',
						dataType: 'json',	
						data: formData,
						async: true,
						processData: false,
						contentType: false,
						success: function (data) {
							if (data.success == true) {
                Toast.fire({
                  icon: 'success',
                  title: data.message
                })
								swal.hideLoading()
                setTimeout(function(){
                  location.reload();
                }, 1000);
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

$('#form-password').submit(function (event) {
		event.preventDefault();
    const id_user = $('#id_user').val();
    let formData = new FormData($('#form-password')[0]);
    formData.append("id_user", id_user);

		Swal.fire({
			title: 'Ubah Password',
			text: "Apakah Anda yakin mengubah password !",
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
						url: '<?= site_url() ?>'+'/user/ubah-password',
						method: 'POST',
						dataType: 'json',	
						data: formData,
						async: true,
						processData: false,
						contentType: false,
						success: function (data) {
							if (data.success == true) {
                Toast.fire({
                  icon: 'success',
                  title: data.message
                })
								swal.hideLoading()
                setTimeout(function(){
                  location.reload();
                }, 1000);
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

function validate_password(){
  var pass = $('#password_baru').val();
  var confirm_pass = $('#konfirmasi_password').val();
  if(pass!=confirm_pass){
    $('#pass-message').show();
    $('#pass-message').text('Password tidak cocok !');
    $('#pass-message').css('color','red');
    $('#submit-reset').prop('disabled',true);
  }else{
    $('#pass-message').hide();
    $('#pass-message').text('');
    $('#pass-message').css('color','white');
    $('#submit-reset').prop('disabled',false);
  }
}

</script>
<?= $this->endSection() ?>