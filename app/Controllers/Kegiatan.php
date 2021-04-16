<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\KegiatanModel;
use App\Models\KelompokKegiatanModel;

class Kegiatan extends BaseController
{	
	use ResponseTrait;
	private $nama_menu = 'Kegiatan';
	public function __construct()
	{
		$this->MKegiatan = new KegiatanModel();
		$this->MKelompok = new KelompokKegiatanModel();
	}

	public function index()
	{
		$app_config = $this->config->app_config();
		$data['aplikasi'] = $app_config;
		$data['title'] = $this->nama_menu." | ".$app_config['nama_sistem'];
		$data['menu'] = $this->nama_menu;
		return view('sistem/master/kegiatan/index', $data);
	}

	public function readData($pg = 1)
	{
		$key	= ($this->request->getPost('cari') != "") ? strtoupper($this->request->getPost('cari')) : "";
		$limit	= $this->request->getPost('limit');
		$column	= $this->request->getPost('column');
		$sort	= $this->request->getPost('sort');
		$offset = ($limit * $pg) - $limit;

		$page              = array();
		$page['limit']     = $limit;
		$page['count_row'] = $this->MKegiatan->listCount($key)['jml'];
		$page['current']   = $pg;
		$page['list']      = gen_paging($page);
		$data['paging']    = $page;
		$data['list']      = $this->MKegiatan->listData($key, $column, $sort, $limit, $offset);

		return view('sistem/master/kegiatan/listData', $data);
	}

	public function loadModal()
	{
		$id = $this->request->getPost('id');
		$kelompokKegiatan = $this->MKelompok->select('id_kelompok_kegiatan, nama_kelompok_kegiatan')
											 ->orderBy('urutan', 'asc')->findAll();
		$data['kelompok_kegiatan'] = $kelompokKegiatan;
		if ($id != "") {
			$data['mode'] = "UPDATE";
			$data['data'] = $this->MKegiatan->find($id);	
		} else {
			$data['mode'] = "ADD";
		}
		return view('sistem/master/kegiatan/modal', $data);
	}

	public function save()
	{
		try {
			$id = $this->request->getPost('id');
			$nama = $this->request->getPost('nama_kegiatan');
			$kelompokKegiatan = $this->request->getPost('kelompok_kegiatan');
			$uuid_v4 = $this->uuid->v4();

			date_default_timezone_set('Asia/Jakarta');
			if($id==""){
				$this->MKegiatan->insert([
					"id_kegiatan" => $uuid_v4,
					"nama_kegiatan" => $nama,
					"id_kelompok_kegiatan" => $kelompokKegiatan, 
				]);
	
				$response['success'] = TRUE;
				$response['message'] = "Data Berhasil Disimpan";
			}else{
				$this->MKegiatan->update($id, [
					"nama_kegiatan" => $nama, 
					"id_kelompok_kegiatan" => $kelompokKegiatan,
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
				$this->MKegiatan->delete($id);

				$response['success'] = true;
				$response['message'] = "Data berhasil dinonaktifkan !";
			}else{
				$response['success'] = false;
				$response['message'] = "Data tidak ditemukan !";
			}
			return $this->respond($response, 200);
		} catch (\Exception $e) {
			$response['success'] = false;
			$response['message'] = "Hapus data gagal !";
			return $this->respond($response, 500);
		}
	}
}
