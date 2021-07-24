<?php namespace App\Models;
use CodeIgniter\Model;

class JenisAktivitasModel extends Model
{
    protected $table = "jenis_aktivitas_mahasiswa";
    protected $primaryKey = 'id_jns_akt_mhs';
    protected $allowedFields = [
        'id_jns_akt_mhs',
        'nm_jns_akt_mhs',
        'ket_jns_akt_mhs',
        'a_kegiatan_kampus_merdeka'
    ];
    protected $useAutoIncrement = false;
    protected $useTimestamps = false;
}
?>