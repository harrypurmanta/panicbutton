<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Golonganmodel;

class Golongan extends BaseController
{

	protected $golonganmodel;
	public function __construct(){
		$this->golonganmodel = new Golonganmodel();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	public function index(){
		$data = [
			'title' => 'Admin Dashboard',
			'subtitle' => 'Dashboard',
			'golongan' => $this->golonganmodel->getbynormal()
		];
		return view('golongan',$data);
	}

	public function save(){
		$golongan_nm = $this->request->getVar('golongan_nm');
		$bygolnm = $this->golonganmodel->getbyGolnm($golongan_nm)->getResult();
		if (count($bygolnm)>0) {
			return 'already';
		} else {
			
			$datenow = date('Y-m-d H:i:s');
			$data = [
			'golongan_nm' => $golongan_nm,
			'status_cd' => 'normal',
			'created_dttm' => $datenow,
			'created_user' => $this->session->user_id
			];

			$save = $this->golonganmodel->save($data);
			if ($save) {
				return true;
			} else {
				return false;
			}
			
		}
	}

	public function update(){
		$id = $this->request->getVar('id');
		$golongan_nm = $this->request->getVar('golongan_nm');
		
			// $session = \Config\Services::session();
			// $session->start();
			$datenow = date('Y-m-d H:i:s');
			$data = [
			'golongan_nm' => $golongan_nm,
			'updated_dttm' => $datenow,
			'updated_user' => $this->session->user_id
			];

			$save = $this->golonganmodel->update($id,$data);
			if ($save) {
				return true;
			} else {
				return false;
			}
		
	}

	public function formedit(){
		$golongan_id = $this->request->getVar('id');
		$res = $this->golonganmodel->find($golongan_id);
		if (count($res)>0) {
				$ret = "<div class='modal-dialog'>"
	            . "<div class='modal-content'>"
	            . "<div class='modal-header'>"
	            . "<h4 class='modal-title'>Silahkan ganti data</h4>"
	             . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"
	            . "</div>"
	            . "<div class='modal-body'>"
	            . "<form>"
	            . "<input type='hidden' value='".$golongan_id."' class='form-control' id='golongan_id'>"
	            . "<div class='form-group'>"
	            . "<label for='recipient-name' class='control-label'>Nama golongan</label>"
	            . "<input type='text' class='form-control' id='golongan_nm' value='".$res['golongan_nm']."'>"
	            . "</div>"
	            . "</form>"
	            . "</div>"
	            . "<div class='modal-footer'>"
	            . "<button type='button' class='btn btn-default waves-effect' data-dismiss='modal'>Close</button>"
	            . "<button onclick='update(".$golongan_id.")' type='button' class='btn btn-danger waves-effect waves-light'>Simpan</button>"
	            . "</div>"
	            . "</div>"
	            . "</div>";
	         return $ret;
		} else {
			
			return 'false';
		}
	}

	public function hapus(){
		$id = $this->request->getVar('id');
		$datenow = date('Y-m-d H:i:s');
		$data = [
		'status_cd' => 'nullified',
		'nullified_dttm' => $datenow,
		'nullified_user' => $this->session->user_id
		];

		$update = $this->golonganmodel->update($id,$data);
		if ($update) {
			return true;
		} else {
			return false;
		}
	}

}
