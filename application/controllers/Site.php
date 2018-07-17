<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	public $app = 'core/layouts/app';
	public $navigation = 'core/elements/navigation';

	public function index()
	{
		$data = [
			'title' => 'Selamat datang di Sehat Yuk',
			'navigation' => $this->navigation,
			'menu' => 'home',
			'page' => 'sites/index'
		];

		$this->load->view($this->app, $data);
	}

	public function puskesmas()
	{
		$data = [
			'title' => 'Daftar Puskesmas | Sehat Yuk',
			'navigation' => $this->navigation,
			'menu' => 'puskesmas',
			'page' => 'puskesmases/index'
		];

		$this->load->view($this->app, $data);
	}

	public function rumahSakitKhusus()
	{
		$data = [
			'title' => 'Daftar Rumah Sakit Khusus | Sehat Yuk',
			'navigation' => $this->navigation,
			'menu' => 'rsk',
			'page' => 'rsks/index'
		];

		$this->load->view($this->app, $data);
	}

	public function rumahSakitUmum()
	{
		$data = [
			'title' => 'Daftar Rumah Sakit Umum | Sehat Yuk',
			'navigation' => $this->navigation,
			'menu' => 'rsu',
			'page' => 'rsus/index'
		];

		$this->load->view($this->app, $data);
	}

	public function notFound()
	{
		$data = [
			'title' => 'Halaman Tidak Ditemukan | Sehat Yuk',
			'page' => 'sites/error'
		];

		$this->load->view($this->app, $data);
	}
}
