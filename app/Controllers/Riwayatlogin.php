<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Riwayatmodel;

class Riwayatlogin extends BaseController
{

	protected $riwayatmodel;
	public function __construct(){
		$this->riwayatmodel = new Riwayatmodel();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	public function index(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
		$data = [
			'title' => 'Admin Dashboard',
			'subtitle' => 'Riwayat User',
			'riwayat' => $this->riwayatmodel->getbynormal()->getResult()
		];
		return view('riwayatlogin',$data);
	}

}
