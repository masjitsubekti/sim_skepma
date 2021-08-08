<div class="row">
  <div class="col-lg-6 col-md-12 col-sm-12">
      <div class="card bg-analytics text-white">
          <div class="card-content">
              <div class="card-body text-center">
                  <img src="<?php echo base_url() ?>/themes/app-assets/images/elements/decore-left.png" class="img-left" alt="card-img-left">
                  <img src="<?php echo base_url() ?>/themes/app-assets/images/elements/decore-right.png" class="img-right" alt="card-img-right">
                  <div class="avatar avatar-xl bg-primary shadow mt-0">
                      <div class="avatar-content">
                          <i class="feather icon-award white font-large-1"></i>
                      </div>
                  </div>
                  <div class="text-center">
                      <?php
                        $nama_user = strtolower(session()->get('auth_nama_user'));
                      ?>
                      <h4 class="mb-2 text-white">Selamat Datang <?= ucwords($nama_user) ?></h4>
                      <p class="m-auto">Aplikasi SIM SKEPMA ini merupakan alat bantu dan media pencatatan kegiatan mahasiswa, silahkan pilih menu disamping untuk memulai.</p>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-lg-3 col-md-6 col-12">
      <div class="card" style="height:245px;">
          <div class="card-header d-flex flex-column pt-3">
              <div class="avatar bg-rgba-primary m-0" style="padding:20px;">
                  <div class="avatar-content">
                      <i class="feather icon-user-check text-primary font-large-1"></i>
                  </div>
              </div>
              <h2 class="text-bold-700 mt-2 mb-25"><?= $dashboard['diverifikasi'] ?></h2>
              <p class="mb-0">Terverifikasi</p>
          </div>
          <div class="card-content"></div>
      </div>
  
      <!-- <div class="card">
          <div class="card-header d-flex flex-column align-items-start pb-0">
              <div class="avatar bg-rgba-primary p-50 m-0">
                  <div class="avatar-content">
                      <i class="feather icon-user-check text-primary font-medium-5"></i>
                  </div>
              </div>
              <h2 class="text-bold-700 mt-1 mb-25">92.6k</h2>
              <p class="mb-0">Subscribers Gained</p>
          </div>
          <div class="card-content" style="height:110px;">
              <div id="subscribe-gain-chart"></div>
          </div>
      </div> -->
  </div>
  <div class="col-lg-3 col-md-6 col-12">
      <div class="card" style="height:245px;">
          <div class="card-header d-flex flex-column pt-3">
              <div class="avatar bg-rgba-warning m-0" style="padding:20px;">
                  <div class="avatar-content">
                      <i class="feather icon-user text-warning font-large-1"></i>
                  </div>
              </div>
              <h2 class="text-bold-600 mt-2 mb-25"><?= $dashboard['menunggu_verifikasi'] ?></h2>
              <p class="mb-0">Menunggu Verifikasi</p>
          </div>
          <div class="card-content"></div>
      </div>
  </div>
</div>
