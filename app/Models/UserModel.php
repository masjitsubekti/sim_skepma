<?php namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = "users";
    protected $primaryKey = 'id_user';
    protected $allowedFields = [
        'id_user', 
        'nama', 
        'username', 
        'email', 
        'password', 
        'status', 
        'created_at', 
        'updated_at',
        'foto',
        'id_role'
    ];
    protected $useAutoIncrement = false;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    function list_count($key=""){
        $query = $this->db->query("
            select count(*) as jml from users us
            join roles r on us.id_role = r.id_role
            where concat(us.nama, us.username, us.email, r.nama) ilike '%$key%'
        ")->getRowArray();
        return $query;
    }

    function list_data($key="", $column="", $sort="", $limit="", $offset=""){
        $query = $this->db->query("
            select us.*, r.nama as nama_role from users us
            join roles r on us.id_role = r.id_role
            where concat(us.nama, us.username, us.email, r.nama) ilike '%$key%'
            order by $column $sort
            limit $limit offset $offset
        ");
        return $query;
    }

    function getRoles(){
        $query = $this->db->table('roles')->select('id_role, nama')->get();
        return $query;
    }
}
?>