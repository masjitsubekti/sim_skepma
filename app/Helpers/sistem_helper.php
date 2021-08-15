<?php
function get_hari($hari){
    switch($hari){
        case 'Sun':
            $hari_ini = "Minggu";
        break;

        case 'Mon':			
            $hari_ini = "Senin";
        break;

        case 'Tue':
            $hari_ini = "Selasa";
        break;

        case 'Wed':
            $hari_ini = "Rabu";
        break;

        case 'Thu':
            $hari_ini = "Kamis";
        break;

        case 'Fri':
            $hari_ini = "Jumat";
        break;

        case 'Sat':
            $hari_ini = "Sabtu";
        break;
        
        default:
            $hari_ini = "Tidak di ketahui";		
        break;
    }
    return $hari_ini;
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

function generate_tanggal_indonesia($tgl){
    $array_bulan=array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu_db = strtotime($tgl);
    $hari = date('d',$waktu_db);
    $bulan = $array_bulan[date('m',$waktu_db)];
    $tahun = date('Y',$waktu_db);
    return $hari.' '.$bulan.' '.$tahun;
}

function tgl_indo($tanggal){
    $date = strtotime($tanggal);
    $tanggal =  date('Y-m-d', $date);
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function format_tanggal($tanggal, $format){
  $date = strtotime($tanggal);
  $tanggal = date($format, $date);
  return $tanggal;
}

?>