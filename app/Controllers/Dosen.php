<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\SkepmaModel;
use App\Models\MahasiswaModel;

class Dosen extends BaseController
{
	use ResponseTrait;
	private $nama_menu = 'Kegiatan Mahasiswa';
	public function __construct()
  {
		$this->MSkepma = new SkepmaModel();
		$this->MMahasiswa = new MahasiswaModel();
  }

	public function index()
	{
		$app_config = $this->config->app_config();
		$data['aplikasi'] = $app_config;
		$data['title'] = $this->nama_menu." | ".$app_config['nama_sistem'];
		$data['menu'] = $this->nama_menu;
		// Breadcrumbs
		$this->breadcrumb->add('Beranda', site_url('beranda'));
		$this->breadcrumb->add('Kegiatan Mahasiswa', site_url('kegiatan-mahasiswa'));
		$data['breadcrumbs'] = $this->breadcrumb->render();

		return view('sistem/dosen/kegiatan/index', $data);
	}

	public function daftarMhs()
	{
		$app_config = $this->config->app_config();
		$data['aplikasi'] = $app_config;
		$data['title'] = $this->nama_menu." | ".$app_config['nama_sistem'];
		$data['menu'] = $this->nama_menu;
		// Breadcrumbs
		$this->breadcrumb->add('Beranda', site_url('beranda'));
		$this->breadcrumb->add('Kegiatan Mahasiswa', site_url('kegiatan-mahasiswa'));
		$data['breadcrumbs'] = $this->breadcrumb->render();

		return view('sistem/dosen/mahasiswa/index', $data);
	}

	public function daftarKegiatanMhs($id_mahasiswa)
	{
		$app_config = $this->config->app_config();
		$data['aplikasi'] = $app_config;
		$data['title'] = $this->nama_menu." | ".$app_config['nama_sistem'];
		$data['menu'] = $this->nama_menu;
		// Breadcrumbs
		$this->breadcrumb->add('Beranda', site_url('beranda'));
		$this->breadcrumb->add('Kegiatan Mahasiswa', site_url('kegiatan-mahasiswa'));
		$data['breadcrumbs'] = $this->breadcrumb->render();
    $data['id_mahasiswa'] = $id_mahasiswa;
	
    return view('sistem/dosen/mahasiswa/daftar_kegiatan', $data);
	}

	public function detailKegiatanMhs($id_skepma)
	{
		$app_config = $this->config->app_config();
		$data['aplikasi'] = $app_config;
		$data['title'] = $this->nama_menu." | ".$app_config['nama_sistem'];
		$data['menu'] = $this->nama_menu;
		// Breadcrumbs
		$this->breadcrumb->add('Beranda', site_url('beranda'));
		$this->breadcrumb->add('Kegiatan Mahasiswa', site_url('kegiatan-mahasiswa'));
		$data['breadcrumbs'] = $this->breadcrumb->render();
		$data['detail'] = $this->MSkepma->getDetailSkepma($id_skepma)->getRowArray();
	
    return view('sistem/dosen/kegiatan/detail_kegiatan', $data);
	}

  public function readDataPengajuanKegiatan($pg = 1)
	{
		$key	= ($this->request->getPost('cari') != "") ? strtoupper($this->request->getPost('cari')) : "";
		$limit	= $this->request->getPost('limit');
		$column	= $this->request->getPost('column');
		$sort	= $this->request->getPost('sort');
		$id_dosen = session()->get('auth_username');
		$offset = ($limit * $pg) - $limit;

		$page              = array();
		$page['limit']     = $limit;
		$page['count_row'] = $this->MSkepma->listCountKegiatanDosen($id_dosen, $key)['jml'];
		$page['current']   = $pg;
		$page['list']      = gen_paging($page);
		$data['paging']    = $page;
		$data['list']      = $this->MSkepma->listDataKegiatanDosen($id_dosen, $key, $column, $sort, $limit, $offset);

		return view('sistem/dosen/kegiatan/list_data', $data);
	}

  public function readDataKegiatanMhs($pg = 1)
	{
    $key	= ($this->request->getPost('cari') != "") ? strtoupper($this->request->getPost('cari')) : "";
		$limit	= $this->request->getPost('limit');
		$column	= $this->request->getPost('column');
		$sort	= $this->request->getPost('sort');
		$id_mahasiswa	= $this->request->getPost('id_mahasiswa');
		$offset = ($limit * $pg) - $limit;

		$page              = array();
		$page['limit']     = $limit;
		$page['count_row'] = $this->MSkepma->listCountKegiatanMhs($id_mahasiswa, $key)['jml'];
		$page['current']   = $pg;
		$page['list']      = gen_paging($page);
		$data['paging']    = $page;
		$data['list']      = $this->MSkepma->listDataKegiatanMhs($id_mahasiswa, $key, $column, $sort, $limit, $offset);

		return view('sistem/skepma/kegiatan/list_data', $data);
	}

  public function readDataMhs($pg = 1)
	{
		$key	= ($this->request->getPost('cari') != "") ? strtoupper($this->request->getPost('cari')) : "";
		$limit	= $this->request->getPost('limit');
		$column	= $this->request->getPost('column');
		$sort	= $this->request->getPost('sort');
		$id_dosen = session()->get('auth_username');
		$offset = ($limit * $pg) - $limit;

		$page              = array();
		$page['limit']     = $limit;
		$page['count_row'] = $this->MMahasiswa->listCountMhs($id_dosen, $key)['jml'];
		$page['current']   = $pg;
		$page['list']      = gen_paging($page);
		$data['paging']    = $page;
		$data['list']      = $this->MMahasiswa->listDataMhs($id_dosen, $key, $column, $sort, $limit, $offset);

		return view('sistem/dosen/mahasiswa/list_data', $data);
	}

	public function editKegiatan($id_kegiatan)
	{
		
	}

  public function updateStatus()
	{
		try {
			if($this->request->getPost('id')){
				$id = $this->request->getPost('id');
        $id_dosen = session()->get('auth_username');

        date_default_timezone_set('Asia/Jakarta');
        $this->MSkepma->update($id, [
					"status" => '2',
					"verified_at" => date('Y-m-d H:i:s'),
					"verified_by" => $id_dosen,
				]);

				$response['success'] = true;
				$response['message'] = "Kegiatan berhasil diverifikasi !";
			}else{
				$response['success'] = false;
				$response['message'] = "Data tidak ditemukan !";
			}
			return $this->respond($response, 200);
		} catch (\Exception $e) {
			$response['success'] = false;
			$response['message'] = "Verifikasi Gagal !";
			return $this->respond($response, 500);
		}
	}
}
