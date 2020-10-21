<?php namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\Panicmodel;

class Home extends BaseController
{
	protected $panicmodel;
	public function __construct(){
		$this->panicmodel = new Panicmodel();
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
			'panic' => $this->panicmodel->countpanic()->getResult(),
			'rs' => $this->panicmodel->countrs()->getResult(),
			'employee' => $this->panicmodel->countemp()->getResult(),
			'medic' => $this->panicmodel->countmedis()->getResult()
		];
		return view('home',$data);
	}

	//--------------------------------------------------------------------

}
