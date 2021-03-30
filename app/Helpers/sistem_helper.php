<?php
function get_apl($self){
    // $CI =& get_instance();
    $CI = $self;
    // $data = $CI ->db
    //             ->where('id','CONF1')
    //             ->get('app_config')
    //             ->getRowArray();

                $data = $self->table('app_config')
                ->where('id', 'CONF1')
                ->limit(1)
                ->get()
                ->getRowArray();
    return $data;     
}
// function is_login(){
//     $CI =& get_instance();
//     $sesi_is_login = $CI->session->userdata('auth_is_login');
//     if($sesi_is_login==TRUE){
//         redirect(site_url('Beranda'));
//     }
// }
function must_login(){
    // $CI = $self;
    $cek = session()->get('auth_is_login'); 
    // $CI->session->userdata('auth_is_login');
    if($cek==FALSE){
        // redirect(site_url());
        redirect()->to(site_url());
    }
}
function get_bulan($bulan){
    $array_bulan=array(
        '01'=>'Januari',
        '02'=>'Februari',
        '03'=>'Maret',
        '04'=>'April',
        '05'=>'Mei',
        '06'=>'Juni',
        '07'=>'Juli',
        '08'=>'Agustus',
        '09'=>'September',
        '10'=>'Oktober',
        '11'=>'November',
        '12'=>'Desember'
    );
    $bulan_ini = $array_bulan[$bulan];
    return $bulan_ini;
}

function format_rupiah($angka){
    $rupiah=number_format($angka,0,',','.');
    return $rupiah;
}

?>