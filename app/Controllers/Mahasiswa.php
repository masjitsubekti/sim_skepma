<?php
namespace App\Controllers;
use App\Models\KelompokKegiatanModel;
use App\Models\KegiatanModel;

class Mahasiswa extends BaseController
{
	private $nama_menu = 'Mahasiswa';
	public function __construct()
    {
		$this->MKelompok = new KelompokKegiatanModel();
		$this->MKegiatan = new KegiatanModel();
    }

	public function auth()
	{

		$data['title'] = 'Login | SIM SKEPMA';
		return view('auth/login', $data);
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

		return view('sistem/mahasiswa/kegiatan/index', $data);
	}

	public function pilihKelompokKegiatan()
	{
		$app_config = $this->config->app_config();
		$data['aplikasi'] = $app_config;
		$data['title'] = $this->nama_menu." | ".$app_config['nama_sistem'];
		$data['menu'] = $this->nama_menu;
		// Breadcrumbs
		$this->breadcrumb->add('Beranda', site_url('beranda'));
		$this->breadcrumb->add('Kelompok Kegiatan', site_url('kegiatan/pilih-kelompok'));
		$data['breadcrumbs'] = $this->breadcrumb->render();
		$kelompokKegiatan = $this->MKelompok->select('id_kelompok_kegiatan, nama_kelompok_kegiatan, keterangan')
											->orderBy('urutan', 'asc')->findAll();

		$data['kelompok_kegiatan'] = $kelompokKegiatan;
		return view('sistem/mahasiswa/kegiatan/pilih_kelompok', $data);
	}

	public function inputKegiatan($id_kelompok)
	{
		$app_config = $this->config->app_config();
		$data['aplikasi'] = $app_config;
		$data['title'] = $this->nama_menu." | ".$app_config['nama_sistem'];
		$data['menu'] = $this->nama_menu;
		// Breadcrumbs
		$this->breadcrumb->add('Beranda', site_url('beranda'));
		$this->breadcrumb->add('Kelompok Kegiatan', site_url('kegiatan/pilih-kelompok'));
		$this->breadcrumb->add('Input Kegiatan', 'javascript:;');
		$data['breadcrumbs'] = $this->breadcrumb->render();

		$kegiatan = $this->MKegiatan->select('id_kegiatan, nama_kegiatan')
									->where('id_kelompok_kegiatan', $id_kelompok)
									->orderBy('nama_kegiatan', 'asc')->findAll();
		$data['kegiatan'] = $kegiatan;
		return view('sistem/mahasiswa/kegiatan/input_kegiatan', $data);
	}

	public function getKategoriByKegiatan()
	{
		
	}
}
