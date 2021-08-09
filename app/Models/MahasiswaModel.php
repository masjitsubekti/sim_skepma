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
      $q = "
          select count(*) as jml from mhs
          where concat(mhsid, mhsnama) ilike '%$key%'
      ";

      if($id_dosen!=""){
        $q .= " and dosid = '$id_dosen' ";
      }

      $query = $this->db->query($q)->getRowArray();
      return $query;
    }

    function listDataMhs($id_dosen="", $key="", $column="", $sort="", $limit="", $offset=""){
        $q = "
            select * from mhs
            where concat(mhsid, mhsnama) ilike '%$key%'
        ";
        
        if($id_dosen!=""){
          $q .= " and dosid = '$id_dosen' ";
        }

        $q .= " 
            order by $column $sort
            limit $limit offset $offset 
        ";
        $query = $this->db->query($q);
        return $query;
    }
}
?>