<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Admissionmodel;
use App\Models\Employeemodel;

class Admission extends BaseController
{

	protected $admissionmodel;
	protected $employeemodel;
	public function __construct(){
		$this->admissionmodel = new Admissionmodel();
		$this->employeemodel = new Employeemodel();
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
			'subtitle' => 'Dashboard',
			'admission' => $this->admissionmodel->getbynormal()->getResult()
		];
		return view('admission',$data);
	}

	public function save(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
		$admission_nm = $this->request->getVar('admission_nm');
		$bygolnm = $this->admissionmodel->getbyGolnm($admission_nm)->getResult();
		if (count($bygolnm)>0) {
			return 'already';
		} else {
			
			$datenow = date('Y-m-d H:i:s');
			$data = [
			'admission_nm' => $admission_nm,
			'status_cd' => 'normal',
			'created_dttm' => $datenow,
			'created_user' => $this->session->user_id
			];

			$save = $this->admissionmodel->save($data);
			if ($save) {
				return true;
			} else {
				return false;
			}
			
		}
	}

	public function update(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
		$id = $this->request->getVar('id');
		$admission_nm = $this->request->getVar('admission_nm');
		
			// $session = \Config\Services::session();
			// $session->start();
			$datenow = date('Y-m-d H:i:s');
			$data = [
			'admission_nm' => $admission_nm,
			'updated_dttm' => $datenow,
			'updated_user' => $this->session->user_id
			];

			$save = $this->admissionmodel->update($id,$data);
			if ($save) {
				return true;
			} else {
				return false;
			}
		
	}

	public function formedit(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
		$admission_id = $this->request->getVar('id');
		$res = $this->admissionmodel->find($admission_id);
		if (count($res)>0) {
				$ret = "<div class='modal-dialog'>"
	            . "<div class='modal-content'>"
	            . "<div class='modal-header'>"
	            . "<h4 class='modal-title'>Silahkan ganti data</h4>"
	             . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"
	            . "</div>"
	            . "<div class='modal-body'>"
	            . "<form>"
	            . "<input type='hidden' value='".$admission_id."' class='form-control' id='admission_id'>"
	            . "<div class='form-group'>"
	            . "<label for='recipient-name' class='control-label'>Nama admission</label>"
	            . "<input type='text' class='form-control' id='admission_nm' value='".$res['admission_nm']."'>"
	            . "</div>"
	            . "</form>"
	            . "</div>"
	            . "<div class='modal-footer'>"
	            . "<button type='button' class='btn btn-default waves-effect' data-dismiss='modal'>Close</button>"
	            . "<button onclick='update(".$admission_id.")' type='button' class='btn btn-danger waves-effect waves-light'>Simpan</button>"
	            . "</div>"
	            . "</div>"
	            . "</div>";
	         return $ret;
		} else {
			
			return 'false';
		}
	}

	public function hapus(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
		$id = $this->request->getVar('id');
		$datenow = date('Y-m-d H:i:s');
		$data = [
		'status_cd' => 'nullified',
		'nullified_dttm' => $datenow,
		'nullified_user' => $this->session->user_id
		];

		$update = $this->admissionmodel->update($id,$data);
		if ($update) {
			return true;
		} else {
			return false;
		}
	}

}
