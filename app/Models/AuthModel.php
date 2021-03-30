<?php namespace App\Models;
use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = "users";
    public function cek_status_by_email($email,$pass=""){
        $query  = $this->db->query("
                select * from users
                where (email = '$email' or username = '$email')  
                limit 1
        ");
        // $query = $this->table('users')
        // ->where('username', $email);
        // ->countAll();
        return $query;
    }
    public function cek_login($user_id){
        $query  = $this->db->query("
                select u.id_user, u.name as nama_user, u.email as email, r.id_roles, r.name as nama_role, u.status, u.foto from users u
                join user_has_roles uhr on u.id_user = uhr.id_user
                join roles r on r.id_roles = uhr.id_roles
                where u.id_user = '$user_id'
        ");
        return $query;
    }
    public function get_role_by_id_user($id){
        $query  = $this->db->query("
                select uhr.id_roles, r.name as nama_role, r.img from users u
                join user_has_roles uhr on u.id_user = uhr.id_user
                join roles r on r.id_roles = uhr.id_roles
                where u.id_roles= '$id'
        ");
        return $query;
    }
}
?>