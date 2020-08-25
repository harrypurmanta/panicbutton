<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Kesatuanmodel;

class Kesatuan extends BaseController
{

	protected $kesatuanmodel;
	public function __construct(){
		$this->kesatuanmodel = new Kesatuanmodel();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	public function index(){
		$data = [
			'title' => 'Admin Dashboard',
			'subtitle' => 'Dashboard',
			'kesatuan' => $this->kesatuanmodel->getbynormal()
		];
		return view('kesatuan',$data);
	}

	public function save(){
		$kesatuan_nm = $this->request->getVar('kesatuan_nm');
		$bygolnm = $this->kesatuanmodel->getbyGolnm($kesatuan_nm)->getResult();
		if (count($bygolnm)>0) {
			return 'already';
		} else {
			
			$datenow = date('Y-m-d H:i:s');
			$data = [
			'kesatuan_nm' => $kesatuan_nm,
			'status_cd' => 'normal',
			'created_dttm' => $datenow,
			'created_user' => $this->session->user_id
			];

			$save = $this->kesatuanmodel->save($data);
			if ($save) {
				return true;
			} else {
				return false;
			}
			
		}
	}

	public function update(){
		$id = $this->request->getVar('id');
		$kesatuan_nm = $this->request->getVar('kesatuan_nm');
		
			// $session = \Config\Services::session();
			// $session->start();
			$datenow = date('Y-m-d H:i:s');
			$data = [
			'kesatuan_nm' => $kesatuan_nm,
			'updated_dttm' => $datenow,
			'updated_user' => $this->session->user_id
			];

			$save = $this->kesatuanmodel->update($id,$data);
			if ($save) {
				return 'true';
			} else {
				return false;
			}
		
	}

	public function formedit(){
		$kesatuan_id = $this->request->getVar('id');
		$res = $this->kesatuanmodel->find($kesatuan_id);
		if (count($res)>0) {
				$ret = "<div class='modal-dialog'>"
	            . "<div class='modal-content'>"
	            . "<div class='modal-header'>"
	            . "<h4 class='modal-title'>Silahkan ganti data</h4>"
	             . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"
	            . "</div>"
	            . "<div class='modal-body'>"
	            . "<form>"
	            . "<input type='hidden' value='".$kesatuan_id."' class='form-control' id='kesatuan_id'>"
	            . "<div class='form-group'>"
	            . "<label for='recipient-name' class='control-label'>Nama kesatuan</label>"
	            . "<input type='text' class='form-control' id='kesatuan_nm' value='".$res['kesatuan_nm']."'>"
	            . "</div>"
	            . "</form>"
	            . "</div>"
	            . "<div class='modal-footer'>"
	            . "<button type='button' class='btn btn-default waves-effect' data-dismiss='modal'>Close</button>"
	            . "<button onclick='update(".$kesatuan_id.")' type='button' class='btn btn-danger waves-effect waves-light'>Simpan</button>"
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

		$update = $this->kesatuanmodel->update($id,$data);
		if ($update) {
			return true;
		} else {
			return false;
		}
	}

}
