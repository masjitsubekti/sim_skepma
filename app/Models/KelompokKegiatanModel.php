<?php namespace App\Models;
use CodeIgniter\Model;

class KelompokKegiatanModel extends Model
{
    protected $table = "m_kelompok_kegiatan";
    protected $primaryKey = 'id_kelompok_kegiatan';
    protected $allowedFields = [
        'id_kelompok_kegiatan', 
        'nama_kelompok_kegiatan', 
        'keterangan', 
        'urutan', 
        'created_at', 
        'updated_at'
    ];
    protected $useAutoIncrement = false;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    function list_count($key=""){
        $query = $this->db->query("
            select count(*) as jml from m_kelompok_kegiatan
            where concat(nama_kelompok_kegiatan, keterangan) ilike '%$key%'
        ")->getRowArray();
        return $query;
    }

    function list_data($key="", $column="", $sort="", $limit="", $offset=""){
        $query = $this->db->query("
            select * from m_kelompok_kegiatan
            where concat(nama_kelompok_kegiatan, keterangan) ilike '%$key%'
            order by $column $sort
            limit $limit offset $offset
        ");
        return $query;
    }
}
?>