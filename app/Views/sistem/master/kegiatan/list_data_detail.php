<?php 
	if($list->getNumRows()!=0){
?>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="tr-head">
            <tr>
                <th width="5%" class="text-center sortable" id="column_waktu" data-sort="desc" onclick="sort_table('#column_waktu','created_at')">No </th>
                <th width="20%" class="sortable" id="column_kategori" data-sort="" onclick="sort_table('#column_kategori','nama_kategori')">Kategori </th>
                <th width="20%" class="sortable" id="column_deskripsi" data-sort="" onclick="sort_table('#column_deskripsi','deskripsi')">Detail Deskripsi </th>
                <th width="10%" class="sortable" id="column_poin" data-sort="" onclick="sort_table('#column_poin','poin')">Poin </th>
                <th width="10%">Bukti Terkait </th>
                <th width="10%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no=($paging['current']-1)*$paging['limit']; 
            foreach ($list->getResult() as $row) { $no++ ?>
                <tr>
                    <td class="text-center" scope="row"><?= $no ?>.</td>
                    <td><?= $row->nama_kategori ?></td>
                    <td><?= $row->deskripsi ?></td>
                    <td class="text-center"><?= $row->poin ?></td>
                    <td class="text-center"><?= $row->bukti_terkait ?></td>
                    <td class="text-center">
                        <a href="javascript:;" data-id="<?=$row->id_detail_kegiatan?>" data-name="<?=$row->kategori?>" class="btn btn-sm btn-icon btn-warning waves-effect waves-light btn-ubah" data-toggle="tooltip" title="Edit Kegiatan"><i style="color:#fff;" class="fa fa-edit"></i></a>
                        <a href="javascript:;" data-id="<?=$row->id_detail_kegiatan?>" data-name="<?=$row->kategori?>" class="btn btn-sm btn-icon btn-danger waves-effect waves-light btn-hapus" data-toggle="tooltip" title="Hapus Kegiatan"><i class="fa fa-trash"></i></a>	    
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
    Data kosong 
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

    $(".btn-ubah").click(function() {
		var id = $(this).attr('data-id');
        var id_kegiatan = $('#id_kegiatan').val();
		$.ajax({
			url: '<?= site_url() ?>'+'/kegiatan/load-modal-detail',
			type: 'post',
			dataType: 'html',
            data:{
                id:id,
                id_kegiatan:id_kegiatan
            },
			beforeSend: function () {},
			success: function (result) {    
				$('#div_modal').html(result);
				$('#modal_title_update').show();
				$('#modeform').val('UPDATE');
				$('#form-modal').modal('show');
			}
		});
	});

    $('.btn-hapus').click(function (e) {
		var id = $(this).attr('data-id');
        var title = $(this).attr('data-name');
  
		Swal.fire({
			title: 'Hapus Detail Kegiatan',
			text: "Apakah Anda yakin menghapus data : "+title,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#95a5a6',
			confirmButtonText: 'Nonaktifkan',
			cancelButtonText: 'Batal',
			showLoaderOnConfirm: true,
			preConfirm: function () {
				return new Promise(function (resolve) {
					$.ajax({
						method: 'POST',
						dataType: 'json',
						url: '<?= site_url() ?>'+'/kegiatan/delete-detail',
						data: {
							id: id
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