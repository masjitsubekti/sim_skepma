<?php namespace App\Models;
use CodeIgniter\Model;

class MenuUserModel extends Model
{
    protected $table = "c_menu_user";
    protected $primaryKey = 'id_menu_user';
    protected $allowedFields = [
        'id_menu_user', 
        'id_menu', 
        'id_role', 
        'id_posisi', 
        'urutan', 
        'id_parent_menu', 
        'level', 
        'created_at', 
        'updated_at',
    ];
    protected $useAutoIncrement = false;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    function list_count($key=""){
        $query = $this->db->query("
            select count(*) as jml from c_menu_user cmu 
            left join c_menu cm on cmu.id_menu = cm.id_menu 
            left join roles r on cmu.id_role = r.id_role 
            where concat(cm.nama_menu, r.nama, cm.keterangan) ilike '%$key%'
        ")->getRowArray();
        return $query;
    }

    function list_data($key="", $column="", $sort="", $limit="", $offset=""){
        $query = $this->db->query("
            select cmu.*, cm.nama_menu, r.nama as nama_role, cm.keterangan from c_menu_user cmu 
            left join c_menu cm on cmu.id_menu = cm.id_menu 
            left join roles r on cmu.id_role = r.id_role 
            where concat(cm.nama_menu, r.nama, cm.keterangan) ilike '%$key%'
            order by $column $sort
            limit $limit offset $offset
        ");
        return $query;
    }

    function get_sub_menu($id_parent_menu){
      $query = $this->db->table('c_menu')->where('id_parent', $id_parent_menu)->get();
      return $query;
    }

    function get_menu_max_level1($id_role="", $level="1"){
      $query = $this->db->query("
            select coalesce(max(urutan),0) as urutan from c_menu_user where id_role = '$id_role' and level = '$level'
            order by urutan asc
      ");
      return $query;
    }

    function get_menu_max_level2($id_role="", $id_parent_menu, $level="2"){
        $query = $this->db->query("
            select coalesce(max(urutan),0) as urutan from c_menu_user 
            where id_role = '$id_role' and id_parent_menu = '$id_parent_menu' and level = '$level'
            order by urutan asc
        ");
        return $query;
    }
}
?>