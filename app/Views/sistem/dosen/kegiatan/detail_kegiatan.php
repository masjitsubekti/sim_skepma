<?= $this->extend('layout/page_layout') ?>
<?= $this->section('content') ?>

<style>
     .d-info {
        background-color: #f5f5f5;
        border-left: 6px solid #2196F3;
        margin-bottom: 15px;
        padding: 12px 12px;
    }
</style>
<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="background-color:#0a85da !important; padding:0.75rem 1.25rem;">
                <span style="color:#ffffff; font-size:12pt;"><i class="fa fa-bars"></i><b> Detail Kegiatan</b></span>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <h5>Detail Mahasiswa</h5>
                    <table class="table">
                        <tbody>
                            <tr> 
                                <th style="width:5%;">Nama Mahasiswa</th>
                                <td style="width:1%;"> : </td>
                                <td style="width:20%; text-align:left;"><?= $detail['nama_mahasiswa'] ?></td>
                            </tr>
                            <tr> 
                                <th style="width:5%;">NPM</th>
                                <td style="width:1%;"> : </td>
                                <td style="width:20%; text-align:left;"><?= $detail['id_mahasiswa'] ?></td>
                            </tr>
                            <tr> 
                                <th style="width:5%;">Tanggal Pengajuan</th>
                                <td style="width:1%;"> : </td>
                                <td style="width:20%; text-align:left;"><?= tgl_indo($detail['created_at']) ?></td>
                            </tr>
                            <tr> 
                                <th style="width:5%;">Status</th>
                                <td style="width:1%;"> : </td>
                                <td style="width:20%; text-align:left;"><?= $detail['status'] ?></td>
                            </tr>
                        </tbody> 
                    </table>  
                    
                    <br>
                    <h5>Deskripsi Kegiatan</h5>
                    <table class="table">
                        <tbody>
                            <tr> 
                                <th style="width:5%;">Nama Kegiatan</th>
                                <td style="width:1%;"> : </td>
                                <td style="width:20%; text-align:left;"><?= $detail['nama_kegiatan'] ?></td>
                            </tr>
                            <tr> 
                                <th style="width:5%;">Tanggal</th>
                                <td style="width:1%;"> : </td>
                                <td style="width:20%; text-align:left;"><?= tgl_indo($detail['tgl_awal']) ?> s/d <?= tgl_indo($detail['tgl_akhir']) ?></td>
                            </tr>
                            <tr> 
                                <th style="width:5%;">Kelompok Kegiatan</th>
                                <td style="width:1%;"> : </td>
                                <td style="width:20%; text-align:left;"><?= $detail['nama_kelompok_kegiatan'] ?></td>
                            </tr>
                            <tr> 
                                <th style="width:5%;">Jenis Kegiatan</th>
                                <td style="width:1%;"> : </td>
                                <td style="width:20%; text-align:left;"><?= $detail['jenis_kegiatan'] ?></td>
                            </tr>
                            <tr> 
                                <th style="width:5%;">Kategori</th>
                                <td style="width:1%;"> : </td>
                                <td style="width:20%; text-align:left;"><?= $detail['kategori'] ?> (<?= $detail['deskripsi'] ?>)</td>
                            </tr>
                            <tr> 
                                <th style="width:5%;">Jenis Aktivitas</th>
                                <td style="width:1%;"> : </td>
                                <td style="width:20%; text-align:left;"><?= $detail['jenis_aktivitas'] ?></td>
                            </tr>
                            <tr> 
                                <th style="width:5%;">Katerangan</th>
                                <td style="width:1%;"> : </td>
                                <td style="width:20%; text-align:left;"><?= $detail['keterangan'] ?></td>
                            </tr>
                            <tr> 
                                <th style="width:5%;">File Bukti</th>
                                <td style="width:1%;"> : </td>
                                <td style="width:20%; text-align:left;">
                                    <?php
                                        $bukti_terkait = $detail['file_bukti'];
                                        if($bukti_terkait!=""){ ?>
                                            <a href="javascript:;" onclick="lihat_dokumen('<?= $detail['file_bukti'] ?>', 'Bukti Terkait')">
                                                <i>Lihat Dokumen</i> 
                                            </a>
                                        <?php }else{ ?>
                                            <i>Dokumen tidak diupload</i>
                                    <?php } ?>   
                                </td>
                            </tr>
                        </tbody> 
                    </table>    

                </div>
            </div>
        </div>
    </div>
</div>
<div id="div_modal"></div>
<script>
  function lihat_dokumen(filenya,judul){
    $.ajax({
        url: '<?= site_url() ?>'+'/dokumen/preview',
        type: 'post',
        dataType: 'html',
        data:{
            filenya:filenya,
            judul:judul,
        },
        beforeSend: function () {},
        success: function (result) {
            $('#div_modal').html(result);
            $('#modal-preview').modal('show');
        }
    });
  }
</script>
<?= $this->endSection() ?>