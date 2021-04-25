<?php
namespace App\Controllers;

class Home extends BaseController
{
	private $nama_menu = 'Beranda';
	public function __construct()
    {
		// must_login();
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

	public function auth()
	{
		$data['title'] = 'Login | SIM SKEPMA';
		return view('auth/login', $data);
	}

}
