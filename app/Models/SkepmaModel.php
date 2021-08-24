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

    function getDetailSkepma ($id_skepma){
        $query = $this->db->query("
            select sk.*, kkg.nama_kelompok_kegiatan, coalesce(dk.kategori::varchar, kt.kategori) as kategori, k.nama_kegiatan as jenis_kegiatan,  
            ja.nm_jns_akt_mhs as jenis_aktivitas, dk.deskripsi, m.mhsnama as nama_mahasiswa
            from t_skepma sk
            left join m_detail_kegiatan dk on dk.id_detail_kegiatan = sk.id_detail_kegiatan
            left join m_kategori kt on dk.id_kategori = kt.id_kategori
            left join m_kegiatan k on k.id_kegiatan = dk.id_kegiatan
            left join m_kelompok_kegiatan kkg on k.id_kelompok_kegiatan = kkg.id_kelompok_kegiatan
            left join jenis_aktivitas_mahasiswa ja on ja.id_jns_akt_mhs = sk.id_jenis_aktivitas
            left join mhs m on sk.id_mahasiswa = m.mhsid
            where sk.id_skepma = '$id_skepma'
        ");
        return $query;
    }

    function getCountStatusKegiatan($id, $is_role){
      $q = "
          select 
            sum(case when sk.status = '1' then 1 else 0 end) as menunggu_verifikasi,
            sum(case when sk.status = '2' then 1 else 0 end) as diverifikasi,
            sum(case when sk.status = '3' then 1 else 0 end) as ditolak
          from t_skepma sk
          join mhs m on sk.id_mahasiswa = m.mhsid
      ";

      if($is_role=='HA02'){
          $q .= " where m.dosid = '$id' ";
      }else if($is_role=='HA03'){
          $q .= " where sk.id_mahasiswa = '$id' ";
      }else{
        // No Actions
      }

      $query = $this->db->query($q);
      return $query;
    }

    /**
     * Report Skepma
     */

    function getLaporanSkepma ($tgl_awal, $tgl_akhir){
      $query = $this->db->query("
          select * from fn_report_skepma('$tgl_awal', '$tgl_akhir')
      ");
      return $query;
    }

    function getLaporanRekapKegiatan ($tgl_awal, $tgl_akhir){
      $query = $this->db->query("
          select * from fn_report_rekapitulasi_kegiatan('$tgl_awal', '$tgl_akhir')
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