<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Sistem Informasi SKEPMA">
    <meta name="keywords" content="Sistem Informasi SKEPMA">
    <meta name="author" content="Masjit Subekti">
    <title><?= $title ?></title>
    <?= $this->include('layout/theme_css') ?>
</head>
<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" style="padding-right:0px !important;">
    <!-- Loader -->
    <!-- <div id="div_dimscreen" class="dimScreen" style="display:none;">
      <div class="lds-ripple"><div></div><div></div></div>
    </div> -->
    <?= $this->include('layout/theme_header') ?>
    <?= $this->include('layout/theme_sidebar') ?>
    <div class="app-content content" style="background: #f6f6f7 !important;">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top" style="margin-top: -10px;">
                        <div class="col-12">
                            <!-- <h2 class="content-header-title float-left mb-0"><?= $menu ?></h2> -->
                            <!-- <div class="breadcrumb-wrapper col-12"> -->
                            <?php 
                                if($menu!='Beranda'){
                                    echo $breadcrumbs;
                                }
                            ?>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Content -->
                <?= $this->renderSection('content') ?>
                <!-- End Content -->
            </div>
        </div>
    </div>
    <?= $this->include('layout/theme_footer') ?>
    <?= $this->include('layout/theme_js') ?>
</body>
</html>
