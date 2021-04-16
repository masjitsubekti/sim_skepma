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
		$data['title'] = 'Beranda | SIM SKEPMA';
		return view('welcome_message', $data);
	}

	public function auth()
	{

		$data['title'] = 'Login | SIM SKEPMA';
		return view('auth/login', $data);
	}

	public function beranda()
	{
		$data['title'] = 'Beranda | SIM SKEPMA';
		$data['menu'] = $this->nama_menu;
		return view('sistem/beranda/beranda', $data);
	}
}
