<?php namespace App\Models;
use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table = "mhs";
    protected $primaryKey = 'mhsid';
    protected $allowedFields = [
        'mhsid',  
        'mhsnama',  
        'dosid',  
    ];
    protected $useAutoIncrement = false;
    protected $useTimestamps = false;

    function listCountMhs($id_dosen="", $key=""){
      $query = $this->db->query("
            select count(*) as jml from mhs
            where concat(mhsnama) ilike '%$key%'
            and dosid = '$id_dosen'
      ")->getRowArray();
      return $query;
    }

    function listDataMhs($id_dosen="", $key="", $column="", $sort="", $limit="", $offset=""){
        $query = $this->db->query("
            select * from mhs
            where concat(mhsnama) ilike '%$key%'
            and dosid = '$id_dosen'
            order by $column $sort
            limit $limit offset $offset
        ");
        return $query;
    }
}
?>