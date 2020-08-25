<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Jabatanmodel;

class jabatan extends BaseController
{

	protected $jabatanmodel;
	public function __construct(){
		$this->jabatanmodel = new Jabatanmodel();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	public function index(){
		$data = [
			'title' => 'Admin Dashboard',
			'subtitle' => 'Dashboard',
			'jabatan' => $this->jabatanmodel->getbynormal()
		];
		return view('jabatan',$data);
	}

	public function save(){
		$jabatan_nm = $this->request->getVar('jabatan_nm');
		$bygolnm = $this->jabatanmodel->getbyGolnm($jabatan_nm)->getResult();
		if (count($bygolnm)>0) {
			return 'already';
		} else {
			
			$datenow = date('Y-m-d H:i:s');
			$data = [
			'jabatan_nm' => $jabatan_nm,
			'status_cd' => 'normal',
			'created_dttm' => $datenow,
			'created_user' => $this->session->user_id
			];

			$save = $this->jabatanmodel->save($data);
			if ($save) {
				return true;
			} else {
				return false;
			}
			
		}
	}

	public function update(){
		$id = $this->request->getVar('id');
		$jabatan_nm = $this->request->getVar('jabatan_nm');
		
			// $session = \Config\Services::session();
			// $session->start();
			$datenow = date('Y-m-d H:i:s');
			$data = [
			'jabatan_nm' => $jabatan_nm,
			'updated_dttm' => $datenow,
			'updated_user' => $this->session->user_id
			];

			$save = $this->jabatanmodel->update($id,$data);
			if ($save) {
				return 'true';
			} else {
				return false;
			}
		
	}

	public function formedit(){
		$jabatan_id = $this->request->getVar('id');
		$res = $this->jabatanmodel->find($jabatan_id);
		if (count($res)>0) {
				$ret = "<div class='modal-dialog'>"
	            . "<div class='modal-content'>"
	            . "<div class='modal-header'>"
	            . "<h4 class='modal-title'>Silahkan ganti data</h4>"
	             . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"
	            . "</div>"
	            . "<div class='modal-body'>"
	            . "<form>"
	            . "<input type='hidden' value='".$jabatan_id."' class='form-control' id='jabatan_id'>"
	            . "<div class='form-group'>"
	            . "<label for='recipient-name' class='control-label'>Nama jabatan</label>"
	            . "<input type='text' class='form-control' id='jabatan_nm' value='".$res['jabatan_nm']."'>"
	            . "</div>"
	            . "</form>"
	            . "</div>"
	            . "<div class='modal-footer'>"
	            . "<button type='button' class='btn btn-default waves-effect' data-dismiss='modal'>Close</button>"
	            . "<button onclick='update(".$jabatan_id.")' type='button' class='btn btn-danger waves-effect waves-light'>Simpan</button>"
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

		$update = $this->jabatanmodel->update($id,$data);
		if ($update) {
			return true;
		} else {
			return false;
		}
	}

}
