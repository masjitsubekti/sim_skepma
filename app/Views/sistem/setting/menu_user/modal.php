<div class="modal fade text-left" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="modal_title_add" style="display:none;"><i class="fa fa-align-justify"></i> Tambah Menu</h5>
                <h5 class="modal-title" id="modal_title_update" style="display:none;"><i class="fa fa-align-justify"></i> Edit Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" id="form">
            <div class="modal-body">
              <input type="hidden" name="modeform" id="modeform">
              <input type="hidden" name="id" id="id">
              <div class="form-group">
                  <label for="provinsi">Hak Akses<span style="color:red;">*</span></label>
                  <select class="form-control" id="hak_akses" name="hak_akses" required>
                      <option value="">Pilih Hak Akses</option>
                      <?php  foreach ($role as $r) { ?>
                          <option value="<?= $r->id_role ?>"><?= $r->nama ?></option>    
                      <?php } ?>
                  </select>
              </div>
              <div class="form-group" id="levels">
                  <label for="level">Level Menu<span style="color:red;">*</span></label>
                  <select class="form-control" id="level" name="level" required>
                      <option value="">Pilih Level Menu</option>
                      <option value="1">Level 1</option>
                      <option value="2">Level 2</option>    
                  </select>
              </div>
              <div class="form-group" id="parent" style="display:none;">
                  <label for="provinsi">Parent Menu<span style="color:red;">*</span></label>
                  <select class="form-control" id="parent_menu" name="parent_menu" required>
                      <option value="">Pilih Parent Menu</option>
                      <?php  foreach ($parent_menu as $pm) { ?>
                          <option value="<?= $pm->id_menu ?>"><?= $pm->nama_menu ?></option>    
                      <?php } ?>
                  </select>
              </div>
              <!-- Sub Menu -->
              <div id="sub" style="display:none;">
                <fieldset class="scheduler-border">
                  <legend class="scheduler-border"><h5><i id="spinner_menu"></i> Pilih Sub Menu</h5></legend>
                  <div class="row">
                    <div class="col-md-12" id="div-notif-menu">
                      <div class="alert alert-info">
                        <h6>Harap <b>Pilih Parent Menu</b> untuk menampilkan sub menu !</h6>
                      </div>
                    </div>
                    <div class="col-md-12" id="div-select-menu" style="display:none;">
                    </div>
                  </div>
                </fieldset>
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
  var selectbox = $('.select-box').bootstrapDualListbox();	
  
  $(document).ready(function(){
    $('#level').change(function(){
      var posisi=$(this).val();
        if(posisi=='1'){
          document.getElementById("parent").style.display = "block";
          document.getElementById("sub").style.display = "none";
        }else if(posisi=='2'){
          document.getElementById("sub").style.display = "block";    
          document.getElementById("parent").style.display = "block";
        }
    });
  });

  $('#parent_menu').change(function(){
      var parent_menu = $(this).val();
      $('#spinner_menu').addClass("fa fa-spin fa-spinner");
      $.ajax({
        url: '<?= site_url() ?>'+'/menu-user/sub-menu',
        type: 'post',
        dataType: 'html',
        data: {
          parent_menu: parent_menu
        },
        beforeSend: function () {},
        success: function (result) {
          setTimeout(function(){ 
            $('#div-notif-menu').hide()
            $('#div-select-menu').show()
            $('#spinner_menu').removeClass();
            $('#div-select-menu').html(result);
          }, 500);
        }
      });
  });

  $('#parent_menu').select2({
    placeholder: "Pilih Parent Menu",
    allowClear: true,
    dropdownParent: $('#parent')
  });

  $('#form').submit(function (event) {
    event.preventDefault();
    Swal.fire({
        title: 'Simpan Menu',
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
                    url: '<?= site_url() ?>'+'/menu-user/save',
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
