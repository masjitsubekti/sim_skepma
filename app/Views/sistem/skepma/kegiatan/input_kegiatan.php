<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<!-- Form -->
<style>
    .select2{
        width:100% !important;
        font-size:10.5pt !important;   
    }
    .error-block{
        font-size: 9pt !important;
    }
    input[type=text]{
        font-size:10.5pt !important;
    }
    textarea{
        font-size:10.5pt !important;    
    }
    .is-invalid .select2-selection, .needs-validation ~ span > .select2-dropdown{
        border-color:red !important;
    }
    .was-validated .form-control:invalid, .form-control.is-invalid {
        background-image: none !important;
    }
</style>


<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="background-color:#3A95D2 !important; padding:0.75rem 1.25rem;">
                <span style="color:#ffffff;"><i class="fa fa-bars"></i><b> Input Kegiatan</b></span>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <b>PENTING!</b>
                                <ol class="pl-3 mb-0">
                                    <li>Lengkapi data formulir berikut. Kolom yang memiliki tanda bintang "*", maka wajib diisi.</li>
                                    <li>Isilah sesuai dengan kaidah-kaidah penulisan bahasa Indonesia untuk mempermudah proses verifikasi.</li>
                                </ol>
                            </div>
                            <br>
                            <form id="form-kegiatan" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="modeform" id="modeform" value="<?= $modeform ?>">
                                <input type="hidden" name="id_skepma" id="id_skepma" value="<?= (isset($skepma)) ? $skepma['id_skepma'] : "" ?>">
                                <div class="form-group">
                                <div class="controls">
                                    <label for="">Nama Kegiatan <span style="color:#e74c3c;">*</span></label>
                                    <input type="text" id="nama_kegiatan" class="form-control" name="nama_kegiatan" autocomplete="off" placeholder="Nama Kegiatan . . ." 
                                    value="<?= (isset($skepma)) ? $skepma['nama_kegiatan'] : ""; ?>"
                                    required>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_aktivitas">Jenis Aktivitas <span style="color:#e74c3c;">*</span></label>
                                        <select class="form-control" id="jenis_aktivitas" name="jenis_aktivitas" data-error="#error-aktivitas" required>
                                            <option value="">Pilih Jenis Aktivitas</option>
                                            <?php foreach ($jenis_aktivitas as $ja) { ?>
                                                <option 
                                                <?php
                                                    if(isset($skepma)){
                                                        if($skepma['id_jenis_aktivitas']==$ja['id_jns_akt_mhs']){
                                                            echo 'selected ';
                                                        }
                                                    }
                                                ?>
                                                value="<?=$ja['id_jns_akt_mhs']?>"> <?=$ja['nm_jns_akt_mhs']?></option>
                                            <?php } ?>
                                        </select>
                                    <div id="error-aktivitas"></div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kategori">Jenis Kegiatan <span style="color:#e74c3c;">*</span></label>
                                        <select class="form-control" id="jenis_kegiatan" name="jenis_kegiatan" data-error="#error-jenis" required>
                                            <option value="">Pilih Jenis Kegiatan</option>
                                            <?php foreach ($jenis_kegiatan as $kel) { ?>                                    
                                                <optgroup label="Kelompok : <?= $kel['nama_kelompok_kegiatan'] ?>">
                                                    <?php foreach ($kel['kegiatan'] as $k) { ?>
                                                        <option
                                                        <?php
                                                            if(isset($skepma)){
                                                                if($skepma['id_kegiatan']==$k['id_kegiatan']){
                                                                    echo 'selected ';
                                                                }
                                                            }
                                                        ?>
                                                        value="<?=$k['id_kegiatan']?>"> <?=$k['nama_kegiatan']?></option>
                                                    <?php } ?>
                                                </optgroup>  
                                            <?php } ?>
                                        </select>
                                    <div id="error-jenis"></div>
                                </div>
                                <div class="form-group">
                                    <label for="kategori">Kategori <span style="color:#e74c3c;">*</span></label>
                                    <div class="controls">
                                        <select class="form-control select-kategori" id="kategori" name="kategori" data-error="#error-kategori" required></select>
                                    </div>
                                    <div id="error-kategori"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Tanggal <span style="color:#e74c3c;">*</span></label>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input type="text" id="tgl_awal" name="tgl_awal" class="form-control date-picker" data-date-format='dd-mm-yyyy' placeholder="Tanggal Mulai . . ." autocomplete="off" onkeypress="return false;"
                                                value="<?= (isset($skepma)) ? $skepma['tgl_awal'] : ""; ?>"
                                                required
                                            >
                                        </div>
                                        <div class="col-md-2" style="text-align: center; padding-left:0px; padding-right:0px;">
                                            <span>s/d</span>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" id="tgl_akhir" name="tgl_akhir" class="form-control date-picker" data-date-format='dd-mm-yyyy' placeholder="Tanggal Selesai . . ." autocomplete="off" onkeypress="return false;" 
                                                value="<?= (isset($skepma)) ? $skepma['tgl_akhir'] : ""; ?>"
                                                required
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan . . ." cols="30" rows="2"><?= (isset($skepma)) ? $skepma['keterangan'] : ""; ?></textarea>
                                </div>          
                                <br>
                                <div class="alert alert-warning"><i class="fa fa-info-circle"></i> Pastikan ukuran file <b>tidak melebihi 2MB</b> dan format file upload yang diijinkan adalah <b>.pdf, .jpg, .jpeg, .png</b>.</div>
                                <div class="rounded p-2" style="border:1px solid #D9D9D9;">
                                    <h4 class="mb-1"> Bukti Terkait <span style="color:#e74c3c;">*</span></h4>
                                    <div class="media flex-column flex-md-row">
                                        <div class="media-aside align-self-start">
                                            <img id="file-img" src="<?php echo base_url('all/images/icon/award.png') ?>" width="150" height="140" class="rounded mr-2 mb-1 mb-md-0">
                                            <div style="text-align:center;" class="rounded mr-2 mb-1 mb-md-0">
                                                <a style="display:none;" href="javascript:;" id="remove_file"><i class="fa fa-times"></i> Batal</a>
                                            </div>
                                        </div>
                                        <div style="width: 100%;">
                                            <small style="color:red;">Ukuran maksimal 2mb</small>
                                            <p class="card-text my-50">File upload</p>
                                            <input type="file" class="form-control" name="file_bukti" accept=".jpg, .png, .jpeg, .pdf" id="input_file_bukti"
                                            <?php if($modeform=='ADD') { echo 'required'; } ?>
                                            >
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <div class="col-md-12" style="text-align:right; padding-right:0px;">
                                    <button type="button" class="btn btn-secondary mr-1" style="background-color:#95a5a6;color:white;"><b>Batal</b></button>
                                    <button type="submit" class="btn btn-primary" style="background-color:#3498db;color:white;"><b><i id="loader-form"></i> Simpan</b></button>
                                </div>
                            </form>                    
                        </div>                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Form -->
<script>
    const modeform = $('#modeform').val();
    $(document).ready(function() {
        if(modeform=='UPDATE'){
            loadDetailKegiatan()
        }
    });

    $('.date-picker').datepicker({
        autoclose: true,
    })
    .on('changeDate', function (e) {
        $(this).blur();    
    });

    $('#jenis_aktivitas').select2({
        placeholder: "Jenis Aktivitas . . .",
        allowClear: true,
    })
    .on('change', function (e) {
        $(this).blur();    
    });

    $('#jenis_kegiatan').select2({
        placeholder: "Jenis Kegiatan . . .",
        allowClear: true,
    })
    .on('change', function (e) {
        $(this).blur();    
    });

    $('#kategori').select2({
        placeholder: "Kategori . . .",
        allowClear: true,
    }).on('change', function (e) {
        $(this).blur();    
    });

    $('#nama_kegiatan').focusout(function(){
        var value=$(this).val();
        if(value=='' || value==null){
            $('#nama_kegiatan').addClass("is-invalid")
        }else{
            $('#nama_kegiatan').removeClass("is-invalid")
        }
    })

    $('#jenis_aktivitas').change(function(){
        var value=$(this).val();
        if(value=='' || value==null){
            $('#jenis_aktivitas + span').addClass("is-invalid")
        }else{
            $('#jenis_aktivitas + span').removeClass("is-invalid")
        }
    })

    $('#kategori').change(function(){
        var value=$(this).val();
        if(value=='' || value==null){
            $('#kategori + span').addClass("is-invalid")
        }else{
            $('#kategori + span').removeClass("is-invalid")
        }
    })
        
    $('#jenis_kegiatan').change(function(){
        var id_kegiatan=$(this).val();
        if(id_kegiatan=='' || id_kegiatan==null){
            $('#jenis_kegiatan + span').addClass("is-invalid")
        }else{
            $('#jenis_kegiatan + span').removeClass("is-invalid")
        }

        $.ajax({
            url : '<?= site_url() ?>'+'/kegiatan/kategori-by-kegiatan',
            method : "POST",
            data : {id_kegiatan : id_kegiatan},
            async : false,
            dataType : 'json',
            success: function(data){
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option value=""></option><option value='+ data[i].id_detail_kegiatan +'>'+data[i].nama_kategori+ ' - ' +data[i].deskripsi+ '</option>';
                }
                $('.select-kategori').html(html); 
            }
        });
    });

    function loadDetailKegiatan(){
        var id_kegiatan = $("#jenis_kegiatan").val();
        $.ajax({
            url : '<?= site_url() ?>'+'/kegiatan/kategori-by-kegiatan',
            method : "POST",
            data : {id_kegiatan : id_kegiatan},
            async : false,
            dataType : 'json',
            success: function(data){
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option value='+ data[i].id_detail_kegiatan +'>'+data[i].nama_kategori+ ' - ' +data[i].deskripsi+ '</option>';
                }
                $('.select-kategori').html(html);

                document.getElementById("kategori").value = '<?= (isset($skepma)) ? $skepma['id_detail_kegiatan'] : ""; ?>';
                var e = document.getElementById("kategori");
                var result = e.options[e.selectedIndex].value;
            }
        });
    }

    $("#input_file_bukti").change(function(e) {
        if( document.getElementById("input_file_bukti").files.length == 0 ){
        }else{
            for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
                var file = e.originalEvent.srcElement.files[i];
                var typeFile = file.name.split('.').pop(); 
                var img = document.getElementById("file-img");
                var reader = new FileReader();
                reader.onloadend = function() {
                    if(typeFile=='pdf' || typeFile=='PDF'){
                        img.src = '<?= base_url() ?>'+'/all/images/icon/pdf.png';
                    }else{
                        img.src = reader.result;
                    }
                }
                reader.readAsDataURL(file);
            }
            $('#remove_file').show();
        }
    });

    $("#remove_file").click( function(){
        $('#input_file_bukti').val('');
        $('#remove_file').hide();
        $("#file-img").attr('src', '<?= base_url() ?>'+'/all/images/icon/award.png');
        // call validation
        $('#input_file_bukti').focus();
        $('#input_file_bukti').blur();
    });

    $("#form-kegiatan").validate({
        errorClass: 'is-invalid error-block',
        rules: {
            nama_kegiatan: {
                required: true,
                minlength: 2,
            },
            jenis_kegiatan:{
                required:true,
            },
            jenis_aktivitas:{
                required:true,
            },
            kateogori:{
                required:true,
            },
            tgl_awal:{
                required:true,
            },
            tgl_akhir:{
                required:true,
            },
            file_bukti: {
                required: function(){
                  if(modeform=='ADD'){
                    return true;
                  }else{
                    return false;
                  }
                } 
            },
        },
        messages: {
            nama_kegiatan: {
                required: "Nama kegiatan harus diisi !",
                minlength: "Minimal 2 karakter !"
            },
            jenis_kegiatan: {
                required: "Jenis kegiatan harus diisi !",
            },
            jenis_aktivitas: {
                required: "Jenis aktivitas harus diisi !",
            },
            kategori: {
                required: "Kategori harus diisi !",
            },
            tgl_awal: {
                required: "Tanggal mulai darus diisi !",
            },
            tgl_akhir: {
                required: "Tanggal selesai harus diisi !",
            },
            file_bukti: {
                required: "Upload file bukti harus diisi !",
            },
        },
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            const jenisKegiatan = $('#jenis_kegiatan').val();
            const jenisAktivitas = $('#jenis_aktivitas').val();
            const kategori = $('#kategori').val();

            if (placement) {
                $(placement).append(error)
                if (jenisKegiatan=="") { 
                    $('#jenis_kegiatan + span').addClass("is-invalid")
                }

                if (jenisAktivitas=="") { 
                    $('#jenis_aktivitas + span').addClass("is-invalid")
                }

                if (kategori=="" || kategori==null) { 
                    $('#kategori + span').addClass("is-invalid")
                }
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $('#loader-form').removeClass();
            $('#loader-form').addClass('fa fa-spinner fa-spin');
            
            $.ajax({
                url: '<?= site_url() ?>'+'/mhs/save-kegiatan-mahasiswa',
                method: 'POST',
                dataType: 'json',    
                data: new FormData($('#form-kegiatan')[0]),
                async: true,
                processData: false,
                contentType: false,
                success: function (data) {
                    setTimeout(function(){ 
                        if (data.success == true) {
                            Swal.fire('Berhasil',data.message,'success');
                            $('#loader-form').removeClass();
                            setTimeout(function(){ 
                                // location.reload();
                                window.location.href = '<?= site_url() ?>'+'/kegiatan-mahasiswa'
                            }, 1000);
                        } else {
                            $('#loader-form').removeClass();
                            toastr.error(data.errors.file_bukti, 'Maaf', {
                                "closeButton": true,
                                "timeOut": 3000
                            });
                        }
                    }, 1000);
                },
                fail: function (e) {
                    alert(e);
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>