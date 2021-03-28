<?php

namespace App\Controllers;
// $parser = \Config\Services::parser();
// $parser = new \CodeIgniter\View\Parser();

class Home extends BaseController
{
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
		return view('sistem/beranda/beranda', $data);

		// $data = [
		// 	'blog_title'   => 'My Blog Title',
		// 	'blog_heading' => 'My Blog Heading',
		// 	'blog_entries' => $query->getResultArray()
		// ];
		// echo $parser->setData($data)->render('sistem/template/template');
	}
}
