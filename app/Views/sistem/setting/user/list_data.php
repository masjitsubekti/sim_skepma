<?php 
	if($list->getNumRows()!=0){
?>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="tr-head">
            <tr>
                <th width="5%" class="text-center">No </th>
                <th width="30%" class="sortable" id="column_nama" data-sort="" onclick="sort_table('#column_nama','nama')">Nama </th>
                <th width="15%" class="sortable text-center" id="column_username" data-sort="" onclick="sort_table('#column_username','username')">Username </th>
                <th width="15%" class="sortable text-center" id="column_email" data-sort="" onclick="sort_table('#column_email','email')">Email </th>
                <th width="15%" class="sortable text-center" id="column_role" data-sort="" onclick="sort_table('#column_role','nama_role')">Role </th>
                <th width="10%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no=($paging['current']-1)*$paging['limit']; 
            foreach ($list->getResult() as $row) { $no++ ?>
                <tr>
                    <td class="text-center" scope="row"><?= $no ?>.</td>
                    <td><?= $row->nama ?></td>
                    <td class="text-center"><?= $row->username ?></td>
                    <td class="text-center"><?= ($row->email!="") ? $row->email : '-' ?></td>
                    <td class="text-center"><?= $row->nama_role ?></td>
                    <td class="text-center">
                        <a href="javascript:;" data-id="<?=$row->id_user?>" data-name="<?=$row->nama?>" class="btn btn-sm btn-icon btn-warning waves-effect waves-light btn-ubah" data-toggle="tooltip" title="Edit User"><i style="color:#fff;" class="fa fa-edit"></i></a>
                        <a href="javascript:;" data-id="<?=$row->id_user?>" data-name="<?=$row->nama?>" class="btn btn-sm btn-icon btn-danger waves-effect waves-light btn-hapus" data-toggle="tooltip" title="Hapus User"><i class="fa fa-trash"></i></a>	    
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
		$.ajax({
			url: '<?= site_url() ?>'+'/user/load-modal',
			type: 'post',
			dataType: 'html',
            data:{id:id},
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
			title: 'Hapus User',
			text: "Apakah Anda yakin data ?",
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
						url: '<?= site_url() ?>'+'/user/delete',
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