<?php namespace App\Models;
use CodeIgniter\Model;

class DetailKegiatanModel extends Model
{
    protected $table = "m_detail_kegiatan";
    protected $primaryKey = 'id_detail_kegiatan';
    protected $allowedFields = [
        'id_detail_kegiatan', 
        'kategori', 
        'deskripsi', 
        'bukti_terkait', 
        'keterangan', 
        'poin', 
        'id_kategori', 
        'id_kegiatan', 
        'created_at', 
        'updated_at',
        'is_entry_kategori'
    ];
    protected $useAutoIncrement = false;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    function listCount($id_kegiatan, $key=""){
        $query = $this->db->query("

            select count(*) as jml from (
                select dk.*, coalesce(dk.kategori::varchar, k.kategori) as nama_kategori from m_detail_kegiatan dk
                left join m_kategori k on dk.id_kategori = k.id_kategori
            )x
            where concat(x.nama_kategori, x.deskripsi, x.bukti_terkait, x.poin) ilike '%$key%'
            and x.id_kegiatan = '$id_kegiatan'
        ")->getRowArray();
        return $query;
    }

    function listData($id_kegiatan, $key="", $column="", $sort="", $limit="", $offset=""){
        $query = $this->db->query("
            select * from(
                select dk.*, coalesce(dk.kategori::varchar, k.kategori) as nama_kategori from m_detail_kegiatan dk
                left join m_kategori k on dk.id_kategori = k.id_kategori
            )x
            where concat(x.nama_kategori, x.deskripsi, x.bukti_terkait, x.poin) ilike '%$key%'
            and x.id_kegiatan = '$id_kegiatan'
            order by $column $sort
            limit $limit offset $offset
        ");
        return $query;
    }
}
?>