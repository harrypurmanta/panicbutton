<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index(){
		$data = [
			'title' => 'Admin Dashboard'
		];
		return view('home',$data);
	}

	//--------------------------------------------------------------------

}
