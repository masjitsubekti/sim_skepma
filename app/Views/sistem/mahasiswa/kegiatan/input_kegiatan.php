<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>
<!-- Form -->

<style>
    .select2{
        width:100% !important;
    }
</style>
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="background-color:#0984e3 !important; padding:0.75rem 1.25rem;">
                <span style="color:#ffffff;"><i class="fa fa-bars"></i><b> Input Kegiatan</b></span>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form>
                                <div class="form-group">
                                    <label for="">Nama Kegiatan</label>
                                    <input type="text" id="nama_kegiatan" class="form-control" name="nama_kegiatan" autocomplete="off" placeholder="Nama Kegiatan">
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kategori">Jenis Kegiatan</label>
                                    <select class="form-control" id="jenis_kegiatan" name="jenis_kegiatan" required>
                                        <option value="">Pilih Jenis Kegiatan</option>
                                        <?php foreach ($kegiatan as $jk) { ?>
                                            <option value="<?=$jk['id_kegiatan']?>"> <?=$jk['nama_kegiatan']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kategori">Kategori</label>
                                    <select class="form-control select-kategori" id="kategori" name="kategori" required>
                                        <!-- <optgroup label="Figures">
                                            <option value="romboid">Romboid</option>
                                            <option value="trapeze">Trapeze</option>
                                            <option value="triangle">Triangle</option>
                                            <option value="polygon">Polygon</option>
                                        </optgroup>
                                        <optgroup label="Colors">
                                            <option value="red">Red</option>
                                            <option value="green">Green</option>
                                            <option value="blue">Blue</option>
                                            <option value="purple">Purple</option>
                                        </optgroup> -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Tanggal</label>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input id="tgl_mulai" name="tgl_mulai" class="form-control date-picker" data-date-format='dd-mm-yyyy' placeholder="Tanggal Mulai" autocomplete="off" onkeypress="return false;" required />
                                        </div>
                                        <div class="col-md-2" style="text-align: center; padding-left:0px; padding-right:0px;">
                                            <span>s/d</span>
                                        </div>
                                        <div class="col-md-5">
                                            <input id="tgl_selesai" name="tgl_selesai" class="form-control date-picker" data-date-format='dd-mm-yyyy' placeholder="Tanggal Selesai" autocomplete="off" onkeypress="return false;" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" cols="30" rows="2"></textarea>
                                </div>          
                                <br>
                                <div class="rounded p-2" style="border:1px solid #D9D9D9;">
                                    <h4 class="mb-1"> Bukti Terkait </h4>
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
                                            <div class="d-inline-block">
                                                <div class="custom-file" id="">
                                                    <input type="file" class="form-control" accept=".jpg, .png, .jpeg, .pdf" id="input_file_bukti">
                                                    <label data-browse="Browse" class="custom-file-label" for="input_file_bukti">
                                                        <span class="d-block form-file-text" style="pointer-events: none;">Choose file</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <div class="col-md-12" style="text-align:right; padding-right:0px;">
                                    <button type="button" class="btn btn-secondary mr-1" style="background-color:#95a5a6;color:white;"><b>Batal</b></button>
                                    <button type="submit" class="btn btn-primary" style="background-color:#3498db;color:white;"><b>Simpan</b></button>
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
    $('.date-picker').datepicker({
        autoclose: true,
    });

    $('#jenis_kegiatan').select2({
        placeholder: "Pilih Jenis Kegiatan",
        allowClear: true,
    });

    $('#kategori').select2({
        placeholder: "Pilih Kategori",
        allowClear: true,
    });

    $('#jenis_kegiatan').change(function(){
        var id_kegiatan=$(this).val();
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
            }
        });
    });

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
    });

</script>
<?= $this->endSection() ?>