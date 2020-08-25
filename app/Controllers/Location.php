<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Locationmodel;

class Location extends BaseController
{

	protected $locationmodel;
	public function __construct(){
		$this->locationmodel = new Locationmodel();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	public function index(){
		$data = [
			'title' => 'Admin Dashboard',
			'subtitle' => 'Dashboard',
			'location' => $this->locationmodel->getbynormal()
		];
		return view('location',$data);
	}

	public function save(){
		$location_nm = $this->request->getVar('location_nm');
		$bygolnm = $this->locationmodel->getbyGolnm($location_nm)->getResult();
		if (count($bygolnm)>0) {
			return 'already';
		} else {
			
			$datenow = date('Y-m-d H:i:s');
			$data = [
			'location_nm' => $location_nm,
			'status_cd' => 'normal',
			'created_dttm' => $datenow,
			'created_user' => $this->session->user_id
			];

			$save = $this->locationmodel->save($data);
			if ($save) {
				return true;
			} else {
				return false;
			}
			
		}
	}

	public function update(){
		$id = $this->request->getVar('id');
		$location_nm = $this->request->getVar('location_nm');
		
			// $session = \Config\Services::session();
			// $session->start();
			$datenow = date('Y-m-d H:i:s');
			$data = [
			'location_nm' => $location_nm,
			'updated_dttm' => $datenow,
			'updated_user' => $this->session->user_id
			];

			$save = $this->locationmodel->update($id,$data);
			if ($save) {
				return 'true';
			} else {
				return false;
			}
		
	}

	public function formedit(){
		$location_id = $this->request->getVar('id');
		$res = $this->locationmodel->find($location_id);
		if (count($res)>0) {
				$ret = "<div class='modal-dialog'>"
	            . "<div class='modal-content'>"
	            . "<div class='modal-header'>"
	            . "<h4 class='modal-title'>Silahkan ganti data</h4>"
	             . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"
	            . "</div>"
	            . "<div class='modal-body'>"
	            . "<form>"
	            . "<input type='hidden' value='".$location_id."' class='form-control' id='location_id'>"
	            . "<div class='form-group'>"
	            . "<label for='recipient-name' class='control-label'>Nama location</label>"
	            . "<input type='text' class='form-control' id='location_nm' value='".$res['location_nm']."'>"
	            . "</div>"
	            . "</form>"
	            . "</div>"
	            . "<div class='modal-footer'>"
	            . "<button type='button' class='btn btn-default waves-effect' data-dismiss='modal'>Close</button>"
	            . "<button onclick='update(".$location_id.")' type='button' class='btn btn-danger waves-effect waves-light'>Simpan</button>"
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

		$update = $this->locationmodel->update($id,$data);
		if ($update) {
			return true;
		} else {
			return false;
		}
	}

}
