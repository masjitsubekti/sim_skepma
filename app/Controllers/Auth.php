<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\AuthModel;

class Auth extends BaseController
{
	use ResponseTrait;
	public function __construct()
	{
		$this->Auth_m = new AuthModel();
	}

	public function index()
	{
		$app_config = $this->config->app_config();
		$data['aplikasi'] = $app_config;
		$data['title'] = "Selamat Datang | " . $app_config['nama_sistem'];
		return view('auth/login', $data);
	}

	public function check_auth()
	{
		$validation =  \Config\Services::validation();
		$username  = $this->request->getPost('username');
		$pass   = $this->request->getPost('password');
		$rules = [
			'username' => 'required',
			'password' => 'required'
		];

		if ($this->validate($rules) == FALSE) {
			$response['success'] = FALSE;
			$response['message'] = "Username atau Password tidak boleh kosong !";
		} else {
			$cek_status = $this->Auth_m->check_auth($username, $pass);
			if ($cek_status->getNumRows() > 0) {
				$detail_user = $cek_status->getRowArray();
				$status = $detail_user['status'];
					// cek status (1 = aktif, 2 = belum diverifikasi, 3 = terblokir)
        if ($status == "3") {
          $response['success'] = false;
          $response['message'] = "Akun Anda diblokir oleh sistem, hubungi pusat bantuan untuk memulihkannya !";
        } else if ($status == "2") {
          $response['success'] = false;
          $response['message'] = "Anda belum memverifikasi Email yang telah kami kirimkan ke " . $detail_user['email'] . " !";
        } else if ($status == "1") {
          $cek_login = $this->Auth_m->check_login($detail_user['id_user']);
          if ($cek_login->getNumRows() > 0) {
            //user ditemukan
            $data_login = $cek_login->getResult();
            $ses_data = array(
              'auth_id_user' => $data_login[0]->id_user,
              'auth_nama_user' => $data_login[0]->nama_user,
              'auth_email' => $data_login[0]->email,
              'auth_username' => $username,
              'auth_foto' => $data_login[0]->foto,
              'auth_is_login' => TRUE,
              'auth_id_role' => $data_login[0]->id_role,
              'auth_nama_role' => $data_login[0]->nama_role,
            );
            session()->set($ses_data);
            $response['success'] = true;
            $response['message'] = "Selamat Datang " . $data_login[0]->nama_user . " !";
            $response['page'] = 'beranda';
          } else {
            //Akun user salah
            $response['success'] = false;
            $response['message'] = "Akun Anda tidak ditemukan !";
          }
        }
			} else {
				$response['success'] = FALSE;
				$response['message'] = "Username atau password salah, silahkan periksa kembali !";;
			}
		}
		return $this->respond($response, 200);
	}

	function logout(){
		session()->destroy();
		$data['success'] = TRUE;
		$data['message'] = "Anda Berhasil Logout !";
		$data['page'] = "Auth";
		echo json_encode($data);
	}
}
