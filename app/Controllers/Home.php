<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
		$data = [
			'title' => 'Admin Dashboard'
		];
		return view('home',$data);
	}

	//--------------------------------------------------------------------

}
