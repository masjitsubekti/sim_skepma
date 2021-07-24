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
        'keterangan',
        'id_jenis_aktivitas' 
    ];
    protected $useAutoIncrement = false;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    function listCountKegiatanMhs($id_mahasiswa="", $key=""){
      $query = $this->db->query("
            select count(*) as jml from t_skepma
            where concat(nama_kegiatan) ilike '%$key%'
            and id_mahasiswa = '$id_mahasiswa'
      ")->getRowArray();
      return $query;
    }

    function listDataKegiatanMhs($id_mahasiswa="", $key="", $column="", $sort="", $limit="", $offset=""){
        $query = $this->db->query("
            select * from t_skepma
            where concat(nama_kegiatan) ilike '%$key%'
            and id_mahasiswa = '$id_mahasiswa'
            order by $column $sort
            limit $limit offset $offset
        ");
        return $query;
    }

    function listCountKegiatanDosen($id_dosen="", $key=""){
      $query = $this->db->query("
            select count(*) as jml from t_skepma sk
            join mhs m on sk.id_mahasiswa = m.mhsid
            where concat(sk.nama_kegiatan, sk.id_mahasiswa, m.mhsnama) ilike '%$key%'
            and m.dosid = '$id_dosen'
      ")->getRowArray();
      return $query;
    }

    function listDataKegiatanDosen($id_dosen="", $key="", $column="", $sort="", $limit="", $offset=""){
        $query = $this->db->query("
            select sk.*, m.mhsnama as nama_mahasiswa from t_skepma sk
            join mhs m on sk.id_mahasiswa = m.mhsid
            where concat(sk.nama_kegiatan, sk.id_mahasiswa, m.mhsnama) ilike '%$key%'
            and m.dosid = '$id_dosen'
            order by $column $sort
            limit $limit offset $offset
        ");
        return $query;
    }

    function rekapitulasiPoinSkepma ($id_mahasiswa){
        $query = $this->db->query("
            select * from fn_rekapitulasi_skepma_mahasiswa('$id_mahasiswa')
        ");
        return $query;
    }
}
?>