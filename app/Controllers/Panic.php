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
		$data = [
			'title' => 'Panic Dashboard',
			'subtitle' => 'History',
			'panic' => $this->panicmodel->getbynormal()
		];
		// echo json_encode($this->panicmodel->getbynormal()->getResult());
		return view('panic',$data);
	}
}