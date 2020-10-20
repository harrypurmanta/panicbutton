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

	public function listadmission() {
		$person_id = $this->request->uri->getSegment(3);
		$data = [
			'title' => 'Riwayat Rekam Medis',
			'subtitle' => 'Riwayat Rekam Medis',
			'admission' => $this->admissionmodel->getbypersonid($person_id)->getResult()
		];

		return view('listadmission',$data);
	}
	public function tambahdata() {
		$person_id = $this->request->uri->getSegment(3);

		$ret = "<div class='modal-dialog modal-lg'>"
	            . "<div class='modal-content'>"
	            . "<div class='modal-header'>"
	            . "<h4 class='modal-title'>Silahkan Tambah Data</h4>"
	             . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"
	            . "</div>"
	            . "<div class='modal-body'>"
	            . "<form class='forms' id='forms' action='post' enctype='multipart/form-data'>"
	            . "<div class='form-group row'>"
	            . "<div class='col-md-5'>"
	            . "<label for='admission_dttm' class='control-label'>Tanggal Admission</label>"
	            . "<input type='date' class='form-control' id='admission_dttm'>"
	            . "</div>"
	             . "<div class='col-md-3'>"
	            . "<label for='tensi' class='control-label'>Tensi</label>"
	            . "<input type='text' class='form-control' id='tensi'>"
	            . "</div>"
	             . "<div class='col-md-3'>"
	            . "<label for='bbtb' class='control-label'>BB/TB</label>"
	            . "<input type='text' class='form-control' id='bbtb'>"
	            . "</div>"
	            . "</div>"
	           	. "<div class='form-group row'>"
	            . "<div class='col-md-5'>"
	            . "<label for='lab' class='control-label'>Laboratorium</label>"
	            . "<textarea type='text' class='form-control' id='lab'></textarea>"
	            . "</div>"
	            . "<div class='col-md-5'>"
	            . "<label for='radiologi' class='control-label'>Radiologi</label>"
	            . "<textarea type='text' class='form-control' id='radiologi'></textarea>"
	            . "</div>"
	             . "<div class='col-md-3'>"
	            . "<label for='mri' class='control-label'>MRI</label>"
	            . "<input type='text' class='form-control' id='mri'>"
	            . "</div>"
	             . "<div class='col-md-3'>"
	            . "<label for='ekg' class='control-label'>EKG</label>"
	            . "<input type='text' class='form-control' id='ekg'>"
	            . "</div>"
	            . "</div>"
	            . "<div class='form-group row'>"
	            . "<div class='col-md-4'>"
	            . "<label for='terapi' class='control-label'>Terapi</label>"
	            . "<textarea type='text' class='form-control' id='terapi'></textarea>"
	            . "</div>"
	             . "<div class='col-md-4'>"
	            . "<label for='diagnosa' class='control-label'>Diagnosa</label>"
	            . "<textarea class='form-control' id='diagnosa'></textarea>"
	            . "</div>"
	             . "<div class='col-md-4'>"
	            . "<label for='saran' class='control-label'>Saran</label>"
	            . "<textarea class='form-control' id='saran'></textarea>"
	            . "</div>"
	            . "</div>"
	            . "</div>"
	            . "<div class='modal-footer'>"
	            . "<button type='button' class='btn btn-default waves-effect' data-dismiss='modal'>Close</button>"
	            . "<button onclick='simpan()' type='button' class='btn btn-danger waves-effect waves-light'>Simpan</button>"
	            . "</form>"
	            . "</div>"
	            . "</div>"
	            . "</div>";

	    return $ret;
	}

	public function save(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }

        $admission_id = $this->admissionmodel->getadmissionid($this->request->getPost('person_id'))->getresult();
        if (count($admission_id)>0) {
        	$admission_idx = $admission_id[0]->admission_id + 1;
        } else {
        	$admission_idx = 1;
        }
        
		$person_id 		= $this->request->getPost('person_id');
		$admission_dttm = $this->request->getPost('admission_dttm');
		$tensi 			= $this->request->getPost('tensi');
		$bbtb 			= $this->request->getPost('bbtb');
		$lab 			= $this->request->getPost('lab');
		$mri 			= $this->request->getPost('mri');
		$ekg 			= $this->request->getPost('ekg');
		$terapi 		= $this->request->getPost('terapi');
		$diagnosa 		= $this->request->getPost('diagnosa');
		$saran 			= $this->request->getPost('saran');
		$radiologi 		= $this->request->getPost('radiologi');
		$datenow 		= date('Y-m-d H:i:s');
		$data = [
			'person_id' => $person_id,
			'admission_dttm' => $admission_dttm." ".date('H:i:s'),
			'admission_id' => $admission_idx,
			'tensi' => $tensi,
			'bbtb' => $bbtb,
			'lab' => $lab,
			'mri' => $mri,
			'ekg' => $ekg,
			'terapi' => $terapi,
			'admission_diag' => $diagnosa,
			'saran' => $saran,
			'radiologi' => $radiologi,
			'status_cd' => 'normal',
			'created_dttm' => $datenow,
			'created_user_id' => $this->session->user_id
		];

		$save = $this->admissionmodel->insertadmission($data);
		if ($save) {
			return true;
		} else {
			return false;
		}
	}

	public function update(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
        if ($this->request->getPost('admission_dttm') == "") {
        	$admission_dttmx = $this->request->getPost('old_admission_dttm');
        } else {
        	$admission_dttmx = $this->request->getPost('admission_dttm')." ".date('H:i:s');
        }
        
		
		$hospital_admission_id 	= $this->request->getPost('id');
		$admission_dttm 		= $admission_dttmx;
		$tensi 					= $this->request->getPost('tensi');
		$bbtb 					= $this->request->getPost('bbtb');
		$lab 					= $this->request->getPost('lab');
		$mri 					= $this->request->getPost('mri');
		$ekg 					= $this->request->getPost('ekg');
		$terapi 				= $this->request->getPost('terapi');
		$diagnosa 				= $this->request->getPost('diagnosa');
		$saran 					= $this->request->getPost('saran');
		$radiologi 				= $this->request->getPost('radiologi');
		$datenow 				= date('Y-m-d H:i:s');
		$data = [
			'admission_dttm' => $admission_dttm,
			'tensi' => $tensi,
			'bbtb' => $bbtb,
			'lab' => $lab,
			'mri' => $mri,
			'ekg' => $ekg,
			'terapi' => $terapi,
			'admission_diag' => $diagnosa,
			'saran' => $saran,
			'radiologi' => $radiologi,
			'status_cd' => 'normal',
			'updated_dttm' => $datenow,
			'updated_user_id' => $this->session->user_id
		];

		$update = $this->admissionmodel->updateadmission($hospital_admission_id,$data);
		if ($update) {
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

        $hospital_admission_id = $this->request->getPost('id');
        $res = $this->admissionmodel->getbyid($hospital_admission_id)->getResult();
        if (count($res)>0) {
        	foreach ($res as $key) {
        		$ret = "<div class='modal-dialog modal-lg'>"
	            . "<div class='modal-content'>"
	            . "<div class='modal-header'>"
	            . "<h4 class='modal-title'>Silahkan Tambah Data</h4>"
	            . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"
	            . "</div>"
	            . "<div class='modal-body'>"
	            . "<form class='forms' id='forms' action='post' enctype='multipart/form-data'>"
	            . "<input type='hidden' value='$key->person_id' id='person_id'/>"
	            . "<div class='form-group row'>"
	            . "<div class='col-md-5'>"
	            . "<input type='hidden' value='$key->admission_dttm' id='old_admission_dttm'/>"
	            . "<label for='admission_dttm' class='control-label'>Tanggal Admission</label> "
	            . "<span style='font-weight: bold;'>$key->admission_dttm</span>"
	            . "<input type='date' class='form-control' id='admission_dttm'>"
	            . "</div>"
	            . "<div class='col-md-3'>"
	            . "<label for='tensi' class='control-label'>Tensi</label>"
	            . "<input type='text' class='form-control' id='tensi' value='$key->tensi'>"
	            . "</div>"
	            . "<div class='col-md-3'>"
	            . "<label for='bbtb' class='control-label'>BB/TB</label>"
	            . "<input type='text' class='form-control' id='bbtb' value='$key->bbtb'>"
	            . "</div>"
	            . "</div>"
	           	. "<div class='form-group row'>"
	            . "<div class='col-md-5'>"
	            . "<label for='lab' class='control-label'>Laboratorium</label>"
	            . "<textarea type='text' class='form-control' id='lab'>$key->lab</textarea>"
	            . "</div>"
	            . "<div class='col-md-5'>"
	            . "<label for='radiologi' class='control-label'>Radiologi</label>"
	            . "<textarea type='text' class='form-control' id='radiologi'>$key->radiologi</textarea>"
	            . "</div>"
	            . "<div class='col-md-3'>"
	            . "<label for='mri' class='control-label'>MRI</label>"
	            . "<input type='text' class='form-control' id='mri' value='$key->mri'>"
	            . "</div>"
	            . "<div class='col-md-3'>"
	            . "<label for='ekg' class='control-label'>EKG</label>"
	            . "<input type='text' class='form-control' id='ekg' value='$key->ekg'>"
	            . "</div>"
	            . "</div>"
	            . "<div class='form-group row'>"
	            . "<div class='col-md-4'>"
	            . "<label for='terapi' class='control-label'>Terapi</label>"
	            . "<textarea type='text' class='form-control' id='terapi'>$key->terapi</textarea>"
	            . "</div>"
	            . "<div class='col-md-4'>"
	            . "<label for='diagnosa' class='control-label'>Diagnosa</label>"
	            . "<textarea class='form-control' id='diagnosa'>$key->admission_diag</textarea>"
	            . "</div>"
	            . "<div class='col-md-4'>"
	            . "<label for='saran' class='control-label'>Saran</label>"
	            . "<textarea class='form-control' id='saran'>$key->saran</textarea>"
	            . "</div>"
	            . "</div>"
	            . "</div>"
	            . "<div class='modal-footer'>"
	            . "<button onclick='hapus($key->hospital_admission_id)' type='button' class='btn btn-danger waves-effect waves-light'>Hapus</button>"
	            . "<button onclick='update($key->hospital_admission_id)' type='button' class='btn btn-primary waves-effect waves-light'>update</button>"
	            . "</form>"
	            . "</div>"
	            . "</div>"
	            . "</div>";
        	}
        } else {
        	$ret = "false";
        }

        return $ret;
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
