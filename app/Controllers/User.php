<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class User extends BaseController
{	
	use ResponseTrait;
	private $nama_menu = 'User';
	public function __construct()
	{
		$this->MUser = new UserModel();
	}

	public function index()
	{
		$app_config = $this->config->app_config();
		$data['aplikasi'] = $app_config;
		$data['title'] = $this->nama_menu." | ".$app_config['nama_sistem'];
		$data['menu'] = $this->nama_menu;
		// Breadcrumbs
		$this->breadcrumb->add('Beranda', site_url('beranda'));
		$this->breadcrumb->add('User', 'javascript:;');
		$data['breadcrumbs'] = $this->breadcrumb->render();

		return view('sistem/setting/user/index', $data);
	}

	public function read_data($pg = 1)
	{
		$key	= ($this->request->getPost('cari') != "") ? strtoupper($this->request->getPost('cari')) : "";
		$limit	= $this->request->getPost('limit');
		$column	= $this->request->getPost('column');
		$sort	= $this->request->getPost('sort');
		$offset = ($limit * $pg) - $limit;

		$page              = array();
		$page['limit']     = $limit;
		$page['count_row'] = $this->MUser->list_count($key)['jml'];
		$page['current']   = $pg;
		$page['list']      = gen_paging($page);
		$data['paging']    = $page;
		$data['list']      = $this->MUser->list_data($key, $column, $sort, $limit, $offset);

		return view('sistem/setting/user/list_data', $data);
	}

	public function load_modal()
	{
		$id = $this->request->getPost('id');
    $data['role'] = $this->MUser->getRoles()->getResultArray();	
		if ($id != "") {
			$data['mode'] = "UPDATE";
			$data['data'] = $this->MUser->find($id);	
		} else {
			$data['mode'] = "ADD";
		}
		return view('sistem/setting/user/modal', $data);
	}

	public function save()
	{
		try {
			$id = $this->request->getPost('id_user');
			$nama = $this->request->getPost('nama');
			$username = $this->request->getPost('username');
			$email = $this->request->getPost('email');
			$password = $this->request->getPost('password');
			$id_role = $this->request->getPost('role');
			$uuid_v4 = $this->uuid->v4();

			date_default_timezone_set('Asia/Jakarta');
			if($id==""){
				$this->MUser->insert([
					"id_user" => $uuid_v4,
					"nama" => $nama, 
					"username" => $username,
					"email" => $email,
					"password" => md5($password),
					"status" => '1',
					"id_role" => $id_role
				]);
	
				$response['success'] = TRUE;
				$response['message'] = "Data user berhasil disimpan";
			}else{
        $dataUser = $this->MUser->find($id);
        $password = ($password!="") ? md5($password) : $dataUser['password'];	

				$this->MUser->update($id, [
					"nama" => $nama, 
					"username" => $username,
					"email" => $email,
					"password" => $password,
					"id_role" => $id_role
				]);
	
				$response['success'] = TRUE;
				$response['message'] = "Data user berhasil diubah";
			}
			return $this->respond($response, 200);
		} catch (\Exception $e) {
      $response['success'] = false;
			$response['message'] = $e->getMessage();
			return $this->respond($response, 200);
		}
	}

	public function delete()
	{
		try {
			if($this->request->getPost('id')){
				$id = $this->request->getPost('id');
				$this->MUser->delete($id);

				$response['success'] = true;
				$response['message'] = "Data berhasil dinonaktifkan !";
			}else{
				$response['success'] = false;
				$response['message'] = "Data tidak ditemukan !";
			}
			return $this->respond($response, 200);
		} catch (\Exception $e) {
			$response['success'] = false;
			$response['message'] = "Hapus data gagal, data sudah digunakan di table lain !";
			return $this->respond($response, 200);
		}
	}

  /**
   * Update Profile Users
   */

  public function profile()
	{
		$app_config = $this->config->app_config();
		$data['aplikasi'] = $app_config;
		$data['title'] = $this->nama_menu." | ".$app_config['nama_sistem'];
		$data['menu'] = $this->nama_menu;
		// Breadcrumbs
		$this->breadcrumb->add('Beranda', site_url('beranda'));
		$this->breadcrumb->add('Profile', 'javascript:;');
		$data['breadcrumbs'] = $this->breadcrumb->render();
    
    $id = session()->get('auth_id_user');
    $data_user = $this->MUser->find($id);
    $data['data_user'] = $data_user;  
		return view('sistem/setting/profile/index', $data);
	}

  function updatePassword() {
    $id = $this->request->getPost('id_user');
    $password = $this->request->getPost("password_baru");
    $konfirmasi_password = $this->request->getPost("konfirmasi_password");
    if($password!=$konfirmasi_password){
      $response['success'] = false;
      $response['message'] = "Maaf, Konfirmasi password tidak sama!";
    }else{
      $password = md5($password);	
      date_default_timezone_set('Asia/Jakarta');
      $this->MUser->update($id, [
        "password" => $password,
      ]);
  
      $response['success'] = true;
      $response['message'] = "Password berhasil diperbarui!";
    }
    return $this->respond($response, 200);	
  }

  function updateProfile() {
    $id = $this->request->getPost('id_user');
    $nama = $this->request->getPost("nama");
    $email = $this->request->getPost("email");
    $cekEmail = $this->db->query("
        select * from users 
        where id_user <> '$id' and UPPER(email) = UPPER('$email')
    ")->getNumRows();

    if($cekEmail!=0){
      $response['success'] = false;
      $response['message'] = "Maaf, Email sudah digunakan!";
    }else{	
      date_default_timezone_set('Asia/Jakarta');
      $this->MUser->update($id, [
        "nama" => $nama,
        "email" => $email,
      ]);
  
      $response['success'] = true;
      $response['message'] = "Password berhasil diperbarui!";
      $response['uid'] = $id;
    }
    return $this->respond($response, 200);	
  }
}
