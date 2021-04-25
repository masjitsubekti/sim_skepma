<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\KegiatanModel;
use App\Models\KelompokKegiatanModel;
use App\Models\DetailKegiatanModel;

class Kegiatan extends BaseController
{	
	use ResponseTrait;
	private $nama_menu = 'Kegiatan';
	public function __construct()
	{
		$this->MKegiatan = new KegiatanModel();
		$this->MKelompok = new KelompokKegiatanModel();
		$this->MDetailKegiatan = new DetailKegiatanModel();
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
		$this->breadcrumb->add('Kegiatan', site_url('master/kegiatan'));
		$data['breadcrumbs'] = $this->breadcrumb->render();
		
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

	/**
	 * Page Detail Kegiatan
	 * Pengisian Detail Kegiatan / Sub Kegiatan (poin dll) 
	 */

	public function detailKegiatan($id_kegiatan)
	{
		$app_config = $this->config->app_config();
		$data['aplikasi'] = $app_config;
		$data['title'] = $this->nama_menu." | ".$app_config['nama_sistem'];
		$data['menu'] = $this->nama_menu;
		// Breadcrumbs
		$this->breadcrumb->add('Beranda', site_url('beranda'));
		$this->breadcrumb->add('Master Data', 'javascript:;');
		$this->breadcrumb->add('Kegiatan', site_url('master/kegiatan'));
		$this->breadcrumb->add('Detail Kegiatan', 'javascript:;');
		$data['breadcrumbs'] = $this->breadcrumb->render();

		$data['id_kegiatan'] = $id_kegiatan;
		return view('sistem/master/kegiatan/detail_kegiatan', $data);
	}

	public function readDataDetail($pg = 1)
	{
		$key	= ($this->request->getPost('cari') != "") ? strtoupper($this->request->getPost('cari')) : "";
		$limit	= $this->request->getPost('limit');
		$column	= $this->request->getPost('column');
		$sort	= $this->request->getPost('sort');
		$id_kegiatan = $this->request->getPost('id_kegiatan');
		$offset = ($limit * $pg) - $limit;

		$page              = array();
		$page['limit']     = $limit;
		$page['count_row'] = $this->MDetailKegiatan->listCount($id_kegiatan, $key)['jml'];
		$page['current']   = $pg;
		$page['list']      = gen_paging($page);
		$data['paging']    = $page;
		$data['list']      = $this->MDetailKegiatan->listData($id_kegiatan, $key, $column, $sort, $limit, $offset);

		return view('sistem/master/kegiatan/list_data_detail', $data);
	}

	public function loadModalDetail()
	{
		$id = $this->request->getPost('id');
		$idKegiatan = $this->request->getPost('id_kegiatan');
		if ($id != "") {
			$data['mode'] = "UPDATE";
			$data['data'] = $this->MDetailKegiatan->find($id);	
		} else {
			$data['mode'] = "ADD";
		}
		$kategori = $this->db->table('m_kategori')
						 ->select('id_kategori, kategori')
						 ->orderBy('id_kategori', 'asc')
						 ->get()->getResult();

		$data['kategori'] = $kategori;
		$data['id_kegiatan'] = $idKegiatan;
		return view('sistem/master/kegiatan/modal_detail', $data);
	}

	public function saveDetail()
	{
		/**
		 * $inputKategori = isian manual
		 * $selectKategori = isian select
		 */
		try {
			$id = $this->request->getPost('id');
			$isEntryKategori = $this->request->getPost('is_entry_kategori');
			$selectKategori = ($isEntryKategori=='false') ? $this->request->getPost('select_kategori') : null;
			$inputKategori = ($isEntryKategori=='true') ? $this->request->getPost('input_kategori') : null;
			$idKegiatan = $this->request->getPost('id_kegiatan');
			$deskripsi = $this->request->getPost('deskripsi');
			$buktiTerkait = $this->request->getPost('bukti_terkait');
			$poin = $this->request->getPost('poin');
			$uuid_v4 = $this->uuid->v4();

			date_default_timezone_set('Asia/Jakarta');
			if($id==""){
				$this->MDetailKegiatan->insert([
					"id_detail_kegiatan" => $uuid_v4,
					"kategori" => $inputKategori,
					"deskripsi" => $deskripsi,
					"bukti_terkait" => $buktiTerkait,
					"poin" => $poin,
					"id_kategori" => $selectKategori,
					"id_kegiatan" => $idKegiatan,
					"keterangan" => null, 
					"is_entry_kategori" => $isEntryKategori 
				]);
	
				$response['success'] = TRUE;
				$response['message'] = "Data Berhasil Disimpan";
			}else{
				$this->MDetailKegiatan->update($id, [
					"id_detail_kegiatan" => $uuid_v4,
					"kategori" => $inputKategori,
					"deskripsi" => $deskripsi,
					"bukti_terkait" => $buktiTerkait,
					"poin" => $poin,
					"id_kategori" => $selectKategori,
					"id_kegiatan" => $idKegiatan,
					"keterangan" => null,
					"is_entry_kategori" => $isEntryKategori
				]);
	
				$response['success'] = TRUE;
				$response['message'] = "Data Berhasil Disimpan";
			}
			return $this->respond($response, 200);
		} catch (\Exception $e) {
			return $this->respond($e->getMessage(), 500);
		}
	}

	public function deleteDetail()
	{
		try {
			if($this->request->getPost('id')){
				$id = $this->request->getPost('id');
				$this->MDetailKegiatan->delete($id);

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

	public function kategoriByIdKegiatan()
	{
		$id_kegiatan=$this->request->getPost('id_kegiatan');
		$data=$this->MDetailKegiatan->getDetailKegiatan($id_kegiatan)->getResult();
		echo json_encode($data);
	}
}
