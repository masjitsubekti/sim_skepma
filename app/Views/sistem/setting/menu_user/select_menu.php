<div class="form-group">
    <?php if($jml_menu==0){ ?>
      <div class="alert alert-danger">
          <h6>
              <i class="fa fa-info-circle"></i> Sub menu tidak ada !
          </h6>
      </div>
    <?php }else{ ?>
      <select style="height:250px !important;" class="form-control select-box menu" id="menu" multiple="multiple" name="menu[]">  
        <?php  foreach ($sub_menu as $sm) { ?>
          <option style="padding-bottom:5px;" value="<?= $sm->id_menu ?>"><?= $sm->nama_menu ?> 
          <?php  echo ($sm->keterangan != "" || $sm->keterangan != NULL) ? ' - '.$sm->keterangan : ""; ?>
          </option>    
        <?php } ?>
      </select>
    <?php } ?>
</div>
<script>
  var selectbox = $('.select-box').bootstrapDualListbox();	
</script>