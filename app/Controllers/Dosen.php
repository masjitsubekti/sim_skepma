<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\KelompokKegiatanModel;
use App\Models\KegiatanModel;
use App\Models\SkepmaModel;
use App\Models\JenisAktivitasModel;

class Dosen extends BaseController
{
	use ResponseTrait;
	private $nama_menu = 'Kegiatan Mahasiswa';
	public function __construct()
  {
		$this->MKelompok = new KelompokKegiatanModel();
		$this->MKegiatan = new KegiatanModel();
		$this->MSkepma = new SkepmaModel();
		$this->MJenisAktivitas = new JenisAktivitasModel();
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

  public function readDataKegiatan($pg = 1)
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

	public function saveKegiatan()
	{	
		try {
			$idMahasiswa = session()->get('auth_username');
			$nama = $this->request->getPost('nama_kegiatan');
			$idDetailKegiatan = $this->request->getPost('kategori'); // id_detail_kegiatan
			$idKelompokKegiatan = $this->request->getPost('kelompok_kegiatan');
			$tglAwal = $this->request->getPost('tgl_awal');
			$tglAkhir = $this->request->getPost('tgl_akhir');
			$keterangan = $this->request->getPost('keterangan');
			$fileBukti = $this->request->getFile('file_bukti');
			$jenisAktivitas = $this->request->getPost('jenis_aktivitas');
			// $semester = $this->request->getPost('semester');

			$rules = [
				'nama_kegiatan' => 'required',
				'kategori' => 'required',
				'jenis_aktivitas' => 'required',
				'tgl_awal' => 'required',
				'tgl_akhir' => 'required',
				'file_bukti' => [
					'rules' => 'uploaded[file_bukti]|mime_in[file_bukti,application/pdf,image/jpg,image/jpeg,image/png]|max_size[file_bukti,2048]',
					'errors' => [
						'uploaded' => 'Harus ada file yang diupload ukuran file maksimal 2 MB',
						'mime_in' => 'File extention harus berupa pdf,jpg,jpeg,png',
						'max_size' => 'Ukuran file maksimal 2 MB'
					]
				]
			];
	
			if ($this->validate($rules) == FALSE) {
				$response['success'] = FALSE;
				$response['message'] = "Isikan data dengan benar sesuai dengan panduan yang tersedia !";
				$response['errors'] = $this->validator->getErrors();
			} else {
				$uuid_v4 = $this->uuid->v4();
				// upload File
				$namaFile = $fileBukti->getRandomName();
				$fileBukti->move('uploads/bukti_kegiatan', $namaFile);

				date_default_timezone_set('Asia/Jakarta');
				$this->MSkepma->insert([
					"id_skepma" => $uuid_v4,
					"nama_kegiatan" => $nama,
					"id_detail_kegiatan" => $idDetailKegiatan, 
					"id_mahasiswa" => $idMahasiswa, 
					"tgl_awal" => $tglAwal, 
					"tgl_akhir" => $tglAkhir, 
					// "semester" => $semester, 
					"file_bukti" => $fileBukti, 
					"status" => '1', // Proses Verifikasi 
					"file_bukti" => $namaFile, 
					"id_kelompok_kegiatan" => $idKelompokKegiatan, 
					"keterangan" => $keterangan, 
					"id_jenis_aktivitas" => $jenisAktivitas, 
				]);
	
				$response['success'] = TRUE;
				$response['message'] = "Data Berhasil Disimpan";
			}
			return $this->respond($response, 200);
		} catch (\Exception $e) {
			return $this->respond($e->getMessage(), 500);
		}
	}
}
