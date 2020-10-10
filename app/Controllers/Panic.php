<?php namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\Panicmodel;

class Panic extends BaseController
{
	protected $panicmodel;
	public function __construct(){
		$this->panicmodel = new Panicmodel();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	public function history(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
		$data = [
			'title' => 'Panic Dashboard',
			'subtitle' => 'History',
			'panic' => $this->panicmodel->getbynormal()
		];
		// echo json_encode($this->panicmodel->getbynormal()->getResult());
		return view('panic',$data);
	}
}