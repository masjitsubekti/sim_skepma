<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\SkepmaModel;

class Home extends BaseController
{
	use ResponseTrait;
	private $nama_menu = 'Beranda';
	public function __construct()
  {
		$this->MSkepma = new SkepmaModel();
  }

	public function index()
	{
		$app_config = $this->config->app_config();
		$data['aplikasi'] = $app_config;
		$data['title'] = $this->nama_menu." | ".$app_config['nama_sistem'];
		$data['menu'] = $this->nama_menu;
		// Breadcrumbs
		$this->breadcrumb->add('Beranda', site_url('beranda'));
		$data['breadcrumbs'] = $this->breadcrumb->render();
		
		return view('sistem/beranda/beranda', $data);
	}

	public function getDataDashboard()
	{
    $id = session()->get('auth_username');
    $role = session()->get('auth_id_role');
    $data['dashboard'] = $this->MSkepma->getCountStatusKegiatan($id, $role)->getRowArray();
 		return view('sistem/beranda/data_dashboard', $data);
	}
}
