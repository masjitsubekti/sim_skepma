<?php 
	if($list->getNumRows()!=0){
?>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="tr-head">
            <tr>
                <th width="5%" class="text-center sortable" id="column_waktu" data-sort="desc" onclick="sort_table('#column_waktu','created_at')">No </th>
                <th width="30%" class="sortable" id="column_nama_kegiatan" data-sort="" onclick="sort_table('#column_nama_kegiatan','nama_kegiatan')">Nama Kegiatan </th>
                <th width="20%" class="sortable" id="column_nama_mhs" data-sort="" onclick="sort_table('#column_nama_mhs','mhsnama')">Mahasiswa </th>
                <th width="10%" class="sortable text-center" id="column_created_at" data-sort="" onclick="sort_table('#column_created_at','created_at')">Tanggal </th>
                <th width="15%" class="text-center">Status</th>
                <th width="12%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no=($paging['current']-1)*$paging['limit']; 
            foreach ($list->getResult() as $row) { $no++ ?>
                <tr>
                    <td class="text-center" scope="row"><?= $no ?>.</td>
                    <td><?= $row->nama_kegiatan ?></td>
                    <td>
                      <?= $row->nama_mahasiswa . ' (' . $row->id_mahasiswa . ')' ?>
                    </td>
                    <td class="text-center"><?= tgl_indo($row->created_at) ?></td>
                    <td class="text-center">
                      <?php 
                        $status = $row->status;
                        if ($status=='1') { ?>
                          <span style="font-size:9pt;" class="badge badge-warning">Proses Verifikasi</span>  
                        <?php }else if($status=='2'){ ?>
                          <span style="font-size:9pt;" class="badge badge-success">Diverifikasi</span>  
                        <?php }else if($status=='3'){ ?>
                          <span style="font-size:9pt;" class="badge badge-danger">Ditolak</span>    
                      <?php } ?>
                    </td>
                    <td class="text-center">
                        <a href="<?= site_url('mhs/detail/'.$row->id_skepma) ?>" class="btn btn-sm btn-icon btn-primary waves-effect waves-light btn-detail" data-toggle="tooltip" title="Detail Kegiatan"><i style="color:#fff;" class="fa fa-eye"></i></a>
                        <a href="javascript:;" data-id="<?=$row->id_skepma?>" data-name="<?=$row->nama_kegiatan?>" class="btn btn-sm btn-icon btn-success waves-effect waves-light btn-verifikasi" data-toggle="tooltip" title="Setujui Kegiatan"><i style="color:#fff;" class="fa fa-check"></i></a>
                        <a href="javascript:;" data-id="<?=$row->id_skepma?>" data-name="<?=$row->nama_kegiatan?>" class="btn btn-sm btn-icon btn-danger waves-effect waves-light btn-tolak" data-toggle="tooltip" title="Tolak Kegiatan"><i class="fa fa-times-circle"></i></a>	    
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="row">
<input type='hidden' id='current' name='current' value='<?php echo $paging['current'] ?>'>
    <br>
    <div class="col-xs-12 col-md-6" style="padding-top:5px; color:#333;">
    Menampilkan data
    <?php $batas_akhir = (($paging['current'])*$paging['limit']);
    if ($batas_akhir > $paging['count_row']) {
        $batas_akhir = $paging['count_row'];
    }
    echo ((($paging['current']-1)*$paging['limit'])+1).' - '.$batas_akhir.' dari total '.$paging['count_row']; ?>
    data
    </div>
    <br>
    <div class="col-xs-12 col-md-6">
        <div style="float:right;">
            <?php echo $paging['list']; ?>
        </div>
    </div>
</div>
<?php }else{ ?>
<div class="table-responsive">
  <table class="table table-bordered table-hover">
      <thead class="tr-head">
          <tr>
              <th width="5%" class="text-center">No </th>
              <th width="40%">Nama Kegiatan </th>
              <th width="15%" class="text-center">Tanggal </th>
              <th width="15%" class="text-center">Status</th>
              <th width="10%" class="text-center">Aksi</th>
          </tr>
      </thead>
      <tbody>
          <tr>
            <td colspan="5">Data tidak ditemukan</td>
          </tr>
      </tbody>
  </table>
</div> 
<?php } ?>
<script>
    function sort_table(id,column){
        var sort = $(id).attr("data-sort");
        $('#input_id_th').val(id);
        $('#input_column').val(column);
        
        if(sort=="asc"){
            sort = 'desc';
        }else if(sort=="desc"){
            sort = 'asc';
        }else{
            sort = 'asc';
        }
        $('#input_sort').val(sort);
        pageLoad(1);
    }

    $('.btn-verifikasi').click(function (e) {
      var id = $(this).attr('data-id');
      var title = $(this).attr('data-name');
    
      Swal.fire({
        title: 'Verifikasi Kegiatan',
        text: "Apakah Anda yakin memverifikasi kegiatan : "+title,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3498db',
        cancelButtonColor: '#95a5a6',
        confirmButtonText: 'Verifikasi',
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true,
        preConfirm: function () {
          return new Promise(function (resolve) {
            $.ajax({
              method: 'POST',
              dataType: 'json',
              url: '<?= site_url() ?>'+'/dosen/verifikasi-kegiatan',
              data: {
                id : id
              },
              success: function (data) {
                if (data.success === true) {
                  Toast.fire({
                    icon: 'success',
                    title: data.message
                  });
                  swal.hideLoading()
                  pageLoad(1);
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message
                  });
                }
              },
              fail: function (e) {
                alert(e);
              }
            });
          });
        },
        allowOutsideClick: false
      });
      e.preventDefault();
	});
</script>