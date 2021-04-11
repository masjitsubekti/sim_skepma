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
			$cek_status = $this->Auth_m->cek_status_by_email($username);
			if ($cek_status->getNumRows() > 0) {
				$detail_user = $cek_status->getRowArray();
				$status = $detail_user['status'];
				$verify_pass = password_verify($pass, $detail_user['password']);
				if ($verify_pass) {
					// cek status (1 = aktif, 2 = belum diverifikasi, 3 = terblokir)
					if ($status == "3") {
						$response['success'] = false;
						$response['message'] = "Akun Anda diblokir oleh sistem, hubungi pusat bantuan untuk memulihkannya !";
					} else if ($status == "2") {
						$response['success'] = false;
						$response['message'] = "Anda belum memverifikasi Email yang telah kami kirimkan ke " . $detail_user['email'] . " !";
					} else if ($status == "1") {
						$cek_login = $this->Auth_m->cek_login($detail_user['id_user']);
						if ($cek_login->getNumRows() > 0) {
							//user ditemukan
							$data_login = $cek_login->getResult();

							$ses_data = array(
								'auth_id_user' => $data_login[0]->id_user,
								'auth_nama_user' => $data_login[0]->nama_user,
								'auth_email' => $data_login[0]->email,
								'auth_username' => $username,
								'auth_foto' => $data_login[0]->foto,
								'auth_pilih_role' => FALSE,
							);
							session()->set($ses_data);

							if ($cek_login->getNumRows() > 1) {
								// user punya lebih dari 1 akses
								$array_pilih = array(
									'auth_pilih_role' => TRUE,
								);
								session()->set($array_pilih);

								$response['success'] = true;
								$response['message'] = "Berhasil Login, Silahkan Pilih Akses !";
								$response['page'] = 'Auth/choose';
							} else {
								//user hanya punya 1 akses
								$array_role = array(
									'auth_pilih_role' => FALSE,
									'auth_is_login' => TRUE,
									'auth_id_role' => $data_login[0]->id_roles,
									'auth_nama_role' => $data_login[0]->nama_role,
								);
								session()->set($array_role);

								$response['success'] = true;
								$response['message'] = "Selamat Datang " . $data_login[0]->nama_user . " !";
								$response['page'] = 'beranda';
							}
						} else {
							//Akun user salah
							$response['success'] = false;
							$response['message'] = "Akun Anda tidak ditemukan !";
						}
					}
				} else {
					$response['success'] = FALSE;
					$response['message'] = "Username atau password salah, silahkan periksa kembali !";
				}
			} else {
				$response['success'] = FALSE;
				$response['message'] = "Akun Anda tidak ditemukan !";
			}
		}
		return $this->respond($response, 200);
	}

	// public function lupa_password()
	// {
	// $db = \Config\Database::connect();
	// $data = $db->query("Select * from users");
	// dd($data);
	// echo "Gas";
	// 	$data['aplikasi'] = $this->apl;
	// 	$data['title'] = "Lupa Password | ".$this->apl['nama_sistem'];
	// 	$this->load->view('front/lupa_password/lupa-password', $data);
	// }

	// public function choose(){ //method yang menampilkan pilihan akses user
	// 	$sesi_pilih_role = $this->session->userdata('auth_pilih_role');
	// 	if($sesi_pilih_role == TRUE){
	// 		$data['aplikasi'] = $this->apl;
	// 		$data['title'] = "Pilih Akses | ".$this->apl['nama_sistem'];

	// 		$id_user = $this->session->userdata('auth_id_user');
	// 		$role = $this->Auth_m->get_role_by_id_user($id_user);
	// 		$data['count_roles'] = $role->num_rows();  
	// 		$data['roles'] = $role->result();  
	// 		$this->parser->parse('front/choose_role', $data);
	// 	}else{
	// 		redirect(site_url());
	// 	}
	// }

	// public function proses_role(){
	// 	$id_role = $this->input->post('id');
	// 	$role = $this->M_main->get_where('roles','id',$id_role)->row_array();
	// 	$array_role = array(
	// 		'auth_pilih_role' => FALSE,
	// 		'auth_is_login' => TRUE,
	// 		'auth_id_role' => $id_role, 
	// 		'auth_nama_role' => $role['name'], 
	// 	);
	// 	$this->session->set_userdata( $array_role );

	// 	$response['success'] = true;
	// 	$response['message'] = "Selamat Datang ".$this->session->userdata('auth_nama_user')." !";
	// 	$response['page'] = 'Beranda';
	// 	insert_log($username, "Login Aplikasi", 'Berhasil Login', $this->input->ip_address(), $this->agent->browser(), $this->agent->agent_string());
	// 	echo json_encode($response);
	// }

	// public function email_reset_password(){
	// 	$email = $this->input->post('email_reset');
	// 	$cek_email = $this->M_main->get_where('users','email',$email);
	// 	$num_email = $cek_email->num_rows();
	// 	if($num_email==0){
	// 	$response['success'] = FALSE;
	// 	$response['message'] = "Maaf email anda tidak terdaftar !";
	// 	insert_log($email, "Reset Password", 'Gagal Kirim Email Verifikasi', $this->input->ip_address(), $this->agent->browser(), $this->agent->agent_string());	
	// 	}else{
	// 	$data_user = $cek_email->row_array();
	// 	$id_user = $data_user['id_user'];
	// 	$nama_lengkap = $data_user['name'];
	// 	$response['success'] = TRUE;
	// 	$response['message'] = "Silahkan cek email anda untuk melanjutkan permintaan reset password !";
	// 	$response['message_email'] = api_reset_pass($id_user,$nama_lengkap, $email);
	// 	insert_log($email, "Reset Password", 'Berhasil Kirim Email Verifikasi', $this->input->ip_address(), $this->agent->browser(), $this->agent->agent_string());			      
	// 	}
	// 	echo json_encode($response);
	// }

	// public function form_reset($id_user){
	// 	$data['aplikasi'] = $this->apl;
	// 	$data['title'] = "Reset Password | ".$this->apl['nama_sistem'];
	// 	$data['id_user'] = $id_user;
	// 	$this->load->view('front/lupa_password/form-reset.php',$data);
	// }   

	// public function simpan_pass(){
	// 	$id_user = $this->input->post('id_user');
	// 	$pass_baru = md5(md5(strip_tags($this->input->post('pass_baru'))));
	// 	$confirm_pass_baru = $this->input->post('confirm_pass_baru');

	// 	$data_user = $this->M_main->get_where('users','id_user',$id_user)->row_array();
	// 	$email = $data_user['email'];

	// 	date_default_timezone_set('Asia/Jakarta');
	// 	$object_update = array(
	// 	'password'=>$pass_baru,
	// 	'updated_at' => date('Y-m-d H:i:s')
	// 	);
	// 	$this->db->where('id_user',$id_user);
	// 	$this->db->update('users',$object_update);

	// 	$response['success'] = TRUE;
	// 	$response['message'] = "Ubah password berhasil, silahkan login dengan password baru anda !";
	// 	$response['page'] = "Auth";
	// 	insert_log($email, "Reset Password", 'Berhasil Ubah Password', $this->input->ip_address(), $this->agent->browser(), $this->agent->agent_string());			      
	// 	echo json_encode($response);
	// }

	// function logout(){
	// 	$username = $this->session->userdata('auth_username');
	// 	insert_log($username, "Logout Aplikasi", 'Berhasil Logout', $this->input->ip_address(), $this->agent->browser(), $this->agent->agent_string());

	// 	$this->session->sess_destroy();
	// 	$data['success'] = TRUE;
	// 	$data['message'] = "Anda Berhasil Logout !";
	// 	$data['page'] = "Auth";
	// 	echo json_encode($data);
	// }
}
