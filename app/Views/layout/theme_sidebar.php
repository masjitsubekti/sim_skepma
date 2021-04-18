<?php 
$db = Config\Database::connect();
$role = 'HA01';
$menu1 = $db->query("
    select m.* from c_menu_user mu
    join c_menu m on mu.id_menu = m.id_menu
    where mu.id_role = '$role' and  level = 1 
    order by mu.urutan asc"
);
?>
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="<?php echo base_url('beranda') ?>">
                    <div class="brand-logo">
                        <img style="width:130px; height:40px; object-fit:cover;" src="<?= base_url() ?>/all/images/logo/logo-itats.png" alt="">
                    </div>
                    <!-- <h2 class="brand-text mb-0">ITATS</h2> -->
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <!-- Menu Sidebar -->
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="navigation-header"><span>Menu Navigasi</span></li>
            <?php foreach ($menu1->getResult() as $m1) {
                $id_menu_level_1 = $m1->id_menu;
                $menu2 = $db->query("
                        select m.* from c_menu_user mu
                        join c_menu m on mu.id_menu = m.id_menu
                        where mu.id_role = '$role' and level = 2 and id_parent_menu = '$id_menu_level_1' 
                        order by mu.urutan asc"
                );
                $jml_menu2 = $menu2->getNumRows();
                if($jml_menu2!=0){ ?>
                    <li class="nav-item <?= ($m1->nama_menu==$menu) ? 'active' : '' ?>">
                        <a href="#">
                            <i class="<?= $m1->class_icon ?>"></i><span class="menu-title" data-i18n="<?= $m1->nama_menu ?>"><?= $m1->nama_menu ?></span>
                        </a>
                        <ul class="menu-content">
                        <?php foreach ($menu2->getResult() as $m2) { ?>
                            <li class="<?= ($m2->nama_menu==$menu) ? 'active' : '' ?>">
                                <a href="<?= site_url($m2->link_menu)?>">
                                    <i class="<?= $m2->class_icon ?>"></i><span class="menu-item" data-i18n="<?= $m2->nama_menu ?>"><?= $m2->nama_menu ?></span>
                                </a>
                            </li>
                        <?php } ?>
                        </ul>
                    </li>
                <?php }else{ ?>
                    <li class="nav-item <?= ($m1->nama_menu==$menu) ? 'active' : '' ?>">
                        <a href="<?= site_url($m1->link_menu)?>">
                            <i class="<?= $m1->class_icon ?>"></i><span class="menu-title" data-i18n="<?= $m1->nama_menu ?>"><?= $m1->nama_menu ?></span>
                        </a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
</div>