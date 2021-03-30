<?php namespace App\Database\Seeds;
use CodeIgniter\I18n\Time;

class UserSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        // users
        $data_user = [
            'id_user'           => 'dcffe310-dee0-4d7d-879e-2cf161d5d67d',
            'name'              => 'Muhammad Alkautsar',
            'username'          => 'superadmin',
            'email'             => 'superadmin@gmail.com',
            'password'          => '$2y$10$06oZZtns85JFTogDBykEW.ygJwiV5H9XQrL/t6XK1v2VIDTA7SrGC',
            'status'            => '1',
            'created_at'        => Time::now(),
            'updated_at'        => Time::now(),
            'email_verified_at' => Time::now(),
            'foto'              => 'superadmin.png',
            'firebase_token'    => ''
        ];
        $this->db->table('users')->insert($data_user);

        // Roles
        $data_roles = [
            'id_roles'   => 'HA01',
            'name'       => 'Superadmin',
            'ket'        => 'Hak Akses Superuser',
            'img'        => 'superadmin.png',
            'created_at' => Time::now(),
            'updated_at' => Time::now(),
        ];
        $this->db->table('roles')->insert($data_roles);

        // User Has Roles
        $data_has_roles = [
            'id_has_roles' => '5a60bb1b-94bc-4725-9b47-e50d6e5e36f0',
            'id_roles'     => 'HA01',
            'id_user'      => 'dcffe310-dee0-4d7d-879e-2cf161d5d67d',
            'created_at'   => Time::now(),
            'updated_at'   => Time::now(),
        ];
        $this->db->table('user_has_roles')->insert($data_has_roles);
    }
} 