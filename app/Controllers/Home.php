<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\SkepmaModel;
use App\Models\DashboardModel;

class Home extends BaseController
{
	use ResponseTrait;
	private $nama_menu = 'Beranda';
	public function __construct()
  {
		$this->MSkepma = new SkepmaModel();
		$this->MDashboard = new DashboardModel();
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
    $role = session()->get('auth_id_role');

    if($role=='HA01'){
      $page = 'sistem/beranda/dashboard';  
    }else{
      $page = 'sistem/beranda/beranda';  
    }
		return view($page, $data);
	}

	public function getDataDashboard()
	{
    $id = session()->get('auth_username');
    $role = session()->get('auth_id_role');
    $data['dashboard'] = $this->MSkepma->getCountStatusKegiatan($id, $role)->getRowArray();
 		return view('sistem/beranda/data_dashboard', $data);
	}

	public function getDataDashboardAdmin()
	{
    $id = session()->get('auth_username');
    $role = session()->get('auth_id_role');
    $data['dashboard'] = $this->MDashboard->getDataDashboard()->getRowArray();
    // Olah data chart
    $chart = $this->MDashboard->getDashboardStatusKegiatan()->getResult();
    $arrayList = [];
    $totalArr = array(0,0,0,0,0,0,0,0,0,0,0,0);
    foreach ($chart as $row) {
      $dataBln = array(
        $row->jan, $row->feb, $row->mar, $row->apr, $row->may, $row->jun, $row->jul, $row->aug, $row->sep, $row->oct, $row->nov, $row->des,
      );
      $arrayList[] = array(
        'name' => $row->status,
        'data' => $dataBln
      );

      $totalArr[0] = $totalArr[0] + $row->jan; 
      $totalArr[1] = $totalArr[1] + $row->feb; 
      $totalArr[2] = $totalArr[2] + $row->mar; 
      $totalArr[3] = $totalArr[3] + $row->apr; 
      $totalArr[4] = $totalArr[4] + $row->may; 
      $totalArr[5] = $totalArr[5] + $row->jun; 
      $totalArr[6] = $totalArr[6] + $row->jul; 
      $totalArr[7] = $totalArr[7] + $row->aug; 
      $totalArr[8] = $totalArr[8] + $row->sep; 
      $totalArr[9] = $totalArr[9] + $row->oct; 
      $totalArr[10] = $totalArr[10] + $row->nov; 
      $totalArr[11] = $totalArr[11] + $row->des; 
    }
    array_push($arrayList, 
      array( 
        'name' => 'Total', 
        'data' => $totalArr
      )
    );

    $data['chart'] = $arrayList; 
    return view('sistem/beranda/data_dashboard_admin', $data);
	}
}
