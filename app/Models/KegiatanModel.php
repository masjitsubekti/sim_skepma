<?php namespace App\Models;
use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table = "m_kegiatan";
    protected $primaryKey = 'id_kegiatan';
    protected $allowedFields = [
        'id_kegiatan', 
        'nama_kegiatan', 
        'id_kelompok_kegiatan', 
        'created_at', 
        'updated_at'
    ];
    protected $useAutoIncrement = false;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    function listCount($key=""){
        $query = $this->db->query("
            select count(*) as jml from m_kegiatan k
            left join m_kelompok_kegiatan kk on k.id_kelompok_kegiatan = kk.id_kelompok_kegiatan
            where concat(k.nama_kegiatan, kk.nama_kelompok_kegiatan) ilike '%$key%'
        ")->getRowArray();
        return $query;
    }

    function listData($key="", $column="", $sort="", $limit="", $offset=""){
        $query = $this->db->query("
            select k.*, kk.nama_kelompok_kegiatan as kelompok_kegiatan from m_kegiatan k
            left join m_kelompok_kegiatan kk on k.id_kelompok_kegiatan = kk.id_kelompok_kegiatan
            where concat(k.nama_kegiatan, kk.nama_kelompok_kegiatan) ilike '%$key%'
            order by $column $sort
            limit $limit offset $offset
        ");
        return $query;
    }
}
?>