<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usersmodel;

class Login extends BaseController
{

	protected $usermodel;
	protected $session;
	public function __construct(){
		$this->usersmodel = new Usersmodel();
	}

	public function index() {
		if (session()->get('user_nm') != "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/home'));
        }
		return view('login');
	}

	public function checklogin() {
		$u = $this->request->getPost('username');
		$p = $this->request->getPost('password');
		$pwd0 = md5($p);
    	
		$res = $this->usersmodel->checklogin($u,$pwd0)->getResultArray();

		if (count($res) > 0) {
			foreach ($res as $k => $v) {
			  	$this->session->set($v);
			  }
		 	return redirect('home');
        } else {
          	return redirect('/');
        } 
	}
}
