<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\KelompokKegiatanModel;

class KelompokKegiatan extends BaseController
{	
	use ResponseTrait;
	private $nama_menu = 'Kelompok Kegiatan';
	public function __construct()
	{
		$this->Kelompok_m = new KelompokKegiatanModel();
	}

	public function index()
	{
		$app_config = $this->config->app_config();
		$data['aplikasi'] = $app_config;
		$data['title'] = $this->nama_menu." | ".$app_config['nama_sistem'];
		$data['menu'] = $this->nama_menu;
		// Breadcrumbs
		$this->breadcrumb->add('Beranda', site_url('beranda'));
		$this->breadcrumb->add('Master Data', 'javascript:;');
		$this->breadcrumb->add('Kelompok Kegiatan', site_url('master/kelompok-kegiatan'));
		$data['breadcrumbs'] = $this->breadcrumb->render();

		return view('sistem/master/kelompok_kegiatan/index', $data);
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
		$page['count_row'] = $this->Kelompok_m->list_count($key)['jml'];
		$page['current']   = $pg;
		$page['list']      = gen_paging($page);
		$data['paging']    = $page;
		$data['list']      = $this->Kelompok_m->list_data($key, $column, $sort, $limit, $offset);

		return view('sistem/master/kelompok_kegiatan/listData', $data);
	}

	public function load_modal()
	{
		$id = $this->request->getPost('id');
		if ($id != "") {
			$data['mode'] = "UPDATE";
			$data['data'] = $this->Kelompok_m->find($id);	
			// $data['data'] = $this->Kelompok_m->where('id_kelompok_kegiatan', $id)->first();	
		} else {
			$data['mode'] = "ADD";
		}
		return view('sistem/master/kelompok_kegiatan/modal', $data);
	}

	public function save()
	{
		try {
			$id = $this->request->getPost('id');
			$nama = $this->request->getPost('nama_kelompok_kegiatan');
			$keterangan = $this->request->getPost('keterangan');
			$urutan = $this->request->getPost('urutan');
			$uuid_v4 = $this->uuid->v4();

			date_default_timezone_set('Asia/Jakarta');
			if($id==""){
				$this->Kelompok_m->insert([
					"id_kelompok_kegiatan" => $uuid_v4,
					"nama_kelompok_kegiatan" => $nama, 
					"keterangan" => $keterangan,
					"urutan" => $urutan
				]);
	
				$response['success'] = TRUE;
				$response['message'] = "Data Berhasil Disimpan";
			}else{
				$this->Kelompok_m->update($id, [
					"nama_kelompok_kegiatan" => $nama, 
					"keterangan" => $keterangan,
					"urutan" => $urutan
				]);
	
				$response['success'] = TRUE;
				$response['message'] = "Data Berhasil Disimpan";
			}
			return $this->respond($response, 200);
		} catch (\Exception $e) {
			return $this->respond($e->getMessage(), 500);
		}
	}

	public function delete()
	{
		try {
			if($this->request->getPost('id')){
				$id = $this->request->getPost('id');
				$this->Kelompok_m->delete($id);

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
