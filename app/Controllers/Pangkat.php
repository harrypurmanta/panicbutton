<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Pangkatmodel;

class Pangkat extends BaseController
{

	protected $pangkatmodel;
	public function __construct(){
		$this->pangkatmodel = new Pangkatmodel();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	public function index(){
		$data = [
			'title' => 'Admin Dashboard',
			'subtitle' => 'Dashboard',
			'pangkat' => $this->pangkatmodel->getbynormal()
		];
		return view('pangkat',$data);
	}

	public function save(){
		$pangkat_nm = $this->request->getVar('pangkat_nm');
		$bygolnm = $this->pangkatmodel->getbyGolnm($pangkat_nm)->getResult();
		if (count($bygolnm)>0) {
			return 'already';
		} else {
			
			$datenow = date('Y-m-d H:i:s');
			$data = [
			'pangkat_nm' => $pangkat_nm,
			'status_cd' => 'normal',
			'created_dttm' => $datenow,
			'created_user' => $this->session->user_id
			];

			$save = $this->pangkatmodel->save($data);
			if ($save) {
				return true;
			} else {
				return false;
			}
			
		}
	}

	public function update(){
		$id = $this->request->getVar('id');
		$pangkat_nm = $this->request->getVar('pangkat_nm');
		
			// $session = \Config\Services::session();
			// $session->start();
			$datenow = date('Y-m-d H:i:s');
			$data = [
			'pangkat_nm' => $pangkat_nm,
			'updated_dttm' => $datenow,
			'updated_user' => $this->session->user_id
			];

			$save = $this->pangkatmodel->update($id,$data);
			if ($save) {
				return 'true';
			} else {
				return false;
			}
		
	}

	public function formedit(){
		$pangkat_id = $this->request->getVar('id');
		$res = $this->pangkatmodel->find($pangkat_id);
		if (count($res)>0) {
				$ret = "<div class='modal-dialog'>"
	            . "<div class='modal-content'>"
	            . "<div class='modal-header'>"
	            . "<h4 class='modal-title'>Silahkan ganti data</h4>"
	             . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"
	            . "</div>"
	            . "<div class='modal-body'>"
	            . "<form>"
	            . "<input type='hidden' value='".$pangkat_id."' class='form-control' id='pangkat_id'>"
	            . "<div class='form-group'>"
	            . "<label for='recipient-name' class='control-label'>Nama pangkat</label>"
	            . "<input type='text' class='form-control' id='pangkat_nm' value='".$res['pangkat_nm']."'>"
	            . "</div>"
	            . "</form>"
	            . "</div>"
	            . "<div class='modal-footer'>"
	            . "<button type='button' class='btn btn-default waves-effect' data-dismiss='modal'>Close</button>"
	            . "<button onclick='update(".$pangkat_id.")' type='button' class='btn btn-danger waves-effect waves-light'>Simpan</button>"
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

		$update = $this->pangkatmodel->update($id,$data);
		if ($update) {
			return true;
		} else {
			return false;
		}
	}

}
