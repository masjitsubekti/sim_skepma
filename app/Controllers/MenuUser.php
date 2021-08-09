<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\MenuUserModel;
use App\Models\UserModel;

class MenuUser extends BaseController
{	
	use ResponseTrait;
	private $nama_menu = 'Role Permission';
	public function __construct()
	{
		$this->MMenu = new MenuUserModel();
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
		$this->breadcrumb->add('Role Permission', 'javascript:;');
		$data['breadcrumbs'] = $this->breadcrumb->render();

		return view('sistem/setting/menu_user/index', $data);
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
		$page['count_row'] = $this->MMenu->list_count($key)['jml'];
		$page['current']   = $pg;
		$page['list']      = gen_paging($page);
		$data['paging']    = $page;
		$data['list']      = $this->MMenu->list_data($key, $column, $sort, $limit, $offset);

		return view('sistem/setting/menu_user/list_data', $data);
	}

	public function load_modal()
	{
		$id = $this->request->getPost('id');
    $data['role'] = $this->MUser->getRoles()->getResult();	
    $data['parent_menu'] = $this->db->table('c_menu')->where('is_parent', '1')->get()->getResult();
    $data['sub_menu'] = $this->db->table('c_menu')->where('is_parent', '2')->get()->getResult();

		if ($id != "") {
			$data['mode'] = "UPDATE";
			$data['data'] = $this->MMenu->find($id);	
		} else {
			$data['mode'] = "ADD";
		}
		return view('sistem/setting/menu_user/modal', $data);
	}

  function get_sub_menu(){
    $id_parent_menu = $this->request->getPost('parent_menu');
    $sub_menu = $this->MMenu->get_sub_menu($id_parent_menu);
    $data['jml_menu'] = $sub_menu->getNumRows();
    $data['sub_menu'] = $sub_menu->getResult();
    return view("sistem/setting/menu_user/select_menu.php", $data);
  }

	public function save()
	{
		try {
			$id_role = $this->request->getPost('hak_akses');
			$id_posisi = $this->request->getPost('posisi');
			$parent_menu = $this->request->getPost('parent_menu');
			$level = $this->request->getPost('level');

			date_default_timezone_set('Asia/Jakarta');
      if($level=='1'){ 
        $max_menu = $this->MMenu->get_menu_max_level1($id_role)->getRowArray();
        $urutan = $max_menu['urutan']+1;
        $uuid_v4 = $this->uuid->v4();
        $data_object = array(
            'id_menu_user'  => $uuid_v4, 
            'id_menu'       => $parent_menu,
            'id_role'       => $id_role,
            'id_posisi'     => '1',
            'urutan'        => $urutan,
            'level'         => $level,
        );
        $this->MMenu->insert($data_object);
        $response['success'] = TRUE;
        $response['message'] = "Data menu berhasil disimpan";
      }else{
        // Sub Menu
        $sub_menu = ($this->request->getPost('menu'));
        if($sub_menu==""){
          $response['success'] = FALSE;
          $response['message'] = "Harap pilih sub menu !";        
        }else{
          $max_menu = $this->MMenu->get_menu_max_level2($id_role, $parent_menu)->getRowArray();
          $urutan = $max_menu['urutan']+1;
          foreach($sub_menu as $menu){
              $uuid_v4 = $this->uuid->v4();
              $data_object = array(
                  'id_menu_user'    => $uuid_v4, 
                  'id_menu'         => $menu,
                  'id_role'         => $id_role,
                  'id_posisi'       => '1',
                  'urutan'          => $urutan,
                  'id_parent_menu'  => $parent_menu,
                  'level'           => $level
              );
              $this->MMenu->insert($data_object);   
              $urutan++;
          }
          $response['success'] = TRUE;
          $response['message'] = "Data menu berhasil disimpan";        
        }
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
				$this->MMenu->delete($id);

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
}
