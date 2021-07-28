<?php 
	if($list->getNumRows()!=0){
?>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="tr-head">
            <tr>
                <th width="5%" class="text-center">No </th>
                <th width="10%" class="sortable" id="column_npm" data-sort="" onclick="sort_table('#column_npm','mhsid')">NPM </th>
                <th width="40%" class="sortable" id="column_nama_mhs" data-sort="" onclick="sort_table('#column_nama_mhs','mhsnama')">Nama Mahasiswa </th>
                <th width="10%" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no=($paging['current']-1)*$paging['limit']; 
            foreach ($list->getResult() as $row) { $no++ ?>
                <tr>
                    <td class="text-center" scope="row"><?= $no ?>.</td>
                    <td><?= $row->mhsid ?></td>
                    <td><?= $row->mhsnama ?></td>
                    <td class="text-center">
                        <a href="<?= site_url('mhs/daftar-kegiatan/'.$row->mhsid) ?>" class="btn btn-sm btn-icon btn-primary waves-effect waves-light btn-detail" data-toggle="tooltip" title="Detail Kegiatan"><i style="color:#fff;" class="fa fa-eye"></i></a>
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
              <th width="10%">NPM </th>
              <th width="40%" class="text-center">Nama Mahasiswa </th>
              <th width="10%" class="text-center">Aksi</th>
          </tr>
      </thead>
      <tbody>
          <tr>
            <td colspan="4">Data tidak ditemukan</td>
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
</script>