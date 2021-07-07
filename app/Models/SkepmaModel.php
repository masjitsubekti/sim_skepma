<?php namespace App\Models;
use CodeIgniter\Model;

class SkepmaModel extends Model
{
    protected $table = "t_skepma";
    protected $primaryKey = 'id_skepma';
    protected $allowedFields = [
        'id_skepma', 
        'nama_kegiatan', 
        'id_detail_kegiatan', 
        'id_mahasiswa', 
        'tgl_awal', 
        'tgl_akhir', 
        'semester', 
        'file_bukti', 
        'status', 
        'created_at', 
        'updated_at',
        'verified_at', 
        'id_kelompok_kegiatan', 
        'verified_by', 
        'keterangan' 
    ];
    protected $useAutoIncrement = false;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
?>