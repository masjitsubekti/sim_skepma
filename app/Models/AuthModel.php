<?php namespace App\Models;
use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = "users";
    public function check_auth($username, $pass=""){
        $query  = $this->db->query("
                select * from users
                where (email = '$username' or username = '$username')  and password = MD5('$pass')
                limit 1
        ");
        return $query;
    }
    public function check_login($user_id){
        $query  = $this->db->query("
                select u.id_user, u.nama as nama_user, u.email as email, u.id_role, r.nama as nama_role, u.status, u.foto from users u
                join roles r on r.id_role = u.id_role
                where u.id_user = '$user_id'
        ");
        return $query;
    }
}
?>