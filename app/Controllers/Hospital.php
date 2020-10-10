<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Hospitalmodel;

class Hospital extends BaseController
{

	protected $hospitalmodel;
	public function __construct(){
		$this->hospitalmodel = new Hospitalmodel();
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
			'hospital' => $this->hospitalmodel->getbynormal()
		];
		return view('hospital',$data);
	}

	public function save(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
		$hospital_nm	 = $this->request->getPost('hospital_nm');
		$telephone		 = $this->request->getPost('telephone');
		$longtitude		 = $this->request->getPost('longtitude');
		$latitude		 = $this->request->getPost('latitude');
		$addr_txt		 = $this->request->getPost('addr_txt');
		$bygolnm = $this->hospitalmodel->getbyGolnm($hospital_nm)->getResult();
		if (count($bygolnm)>0) {
			return 'already';
		} else {
			$datenow = date('Y-m-d H:i:s');
			$data = [
			'hospital_nm' => $hospital_nm,
			'telephone' => $telephone,
			'longtitude' => $longtitude,
			'latitude' => $latitude,
			'addr_txt' => $addr_txt,
			'status_cd' => 'normal',
			'created_dttm' => $datenow,
			'created_user' => $this->session->user_id
			];

			$save = $this->hospitalmodel->save($data);
			if ($save) {
				return 'true';
			} else {
				return 'false';
			}
		}
	}

	public function update(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }

		$id = $this->request->getVar('id');
		$hospital_nm = $this->request->getVar('hospital_nm');
		$telephone		 = $this->request->getPost('telephone');
		$longtitude		 = $this->request->getPost('longtitude');
		$latitude		 = $this->request->getPost('latitude');
		$addr_txt		 = $this->request->getPost('addr_txt');
			$datenow = date('Y-m-d H:i:s');
			$data = [
			'hospital_nm' => $hospital_nm,
			'telephone' => $telephone,
			'longtitude' => $longtitude,
			'latitude' => $latitude,
			'addr_txt' => $addr_txt,
			'updated_dttm' => $datenow,
			'updated_user' => $this->session->user_id
			];

			$save = $this->hospitalmodel->update($id,$data);
			if ($save) {
				return 'true';
			} else {
				return false;
			}
		
	}

	public function formedit(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
		$hospital_id = $this->request->getVar('id');
		$res = $this->hospitalmodel->find($hospital_id);
		if ($hospital_id != "") {
				$ret = "<div class='modal-dialog'>"
	            . "<div class='modal-content'>"
	            . "<div class='modal-header'>"
	            . "<h4 class='modal-title'>Silahkan ganti data</h4>"
	             . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"
	            . "</div>"
	            . "<div class='modal-body'>"
	            . "<form>"
	            . "<input type='hidden' value='".$hospital_id."' class='form-control' id='hospital_id'>"
	            . "<div class='form-group'>"
	            . "<label for='recipient-name' class='control-label'>Nama hospital</label>"
	            . "<input type='text' class='form-control hospital' id='hospital_nm' value='".$res['hospital_nm']."'>"
	            . "</div>"
	            . "<div class='form-group'>"
	            . "<label class='control-label'>Telephone</label>"
	            . "<input type='text' class='form-control hospital' id='telephone' value='".$res['telephone']."'>"
	            . "</div>"
	            . "<div class='form-group'>"
	            . "<label class='control-label'>Longtitude</label>"
	            . "<input type='text' class='form-control hospital' id='longtitude' value='".$res['longitude']."'>"
	            . "</div>"
	            . "<div class='form-group'>"
	            . "<label class='control-label'>Latitude</label>"
	            . "<input type='text' class='form-control hospital' id='latitude' value='".$res['latitude']."'>"
	            . "</div>"
	            . "<div class='form-group'>"
	            . "<label class='control-label'>Alamat</label>"
	            . "<textarea class='form-control hospital' id='addr_txt'>".$res['addr_txt']."</textarea>"
	            . "</div>"
	            . "</form>"
	            . "</div>"
	            . "<div class='modal-footer'>"
	            . "<button type='button' class='btn btn-default waves-effect' data-dismiss='modal'>Close</button>"
	            . "<button onclick='update(".$hospital_id.")' type='button' class='btn btn-danger waves-effect waves-light'>Simpan</button>"
	            . "</div>"
	            . "</div>"
	            . "</div>";
	        
		} else {
			$ret = "<div class='modal-dialog'>"
	            . "<div class='modal-content'>"
	            . "<div class='modal-header'>"
	            . "<h4 class='modal-title'>Silahkan ganti data</h4>"
	             . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"
	            . "</div>"
	            . "<div class='modal-body'>"
	            . "<form>"
	            . "<div class='form-group'>"
	            . "<label class='control-label'>Nama hospital</label>"
	            . "<input type='text' class='form-control hospital' id='hospital_nm'>"
	            . "</div>"
	            . "<div class='form-group'>"
	            . "<label class='control-label'>Telephone</label>"
	            . "<input type='text' class='form-control hospital' id='telephone'>"
	            . "</div>"
	            . "<div class='form-group'>"
	            . "<label class='control-label'>Longtitude</label>"
	            . "<input type='text' class='form-control hospital' id='longtitude'>"
	            . "</div>"
	            . "<div class='form-group'>"
	            . "<label class='control-label'>Latitude</label>"
	            . "<input type='text' class='form-control hospital' id='latitude'>"
	            . "</div>"
	            . "<div class='form-group'>"
	            . "<label class='control-label'>Alamat</label>"
	            . "<textarea class='form-control hospital' id='addr_txt'></textarea>"
	            . "</div>"
	            . "</form>"
	            . "</div>"
	            . "<div class='modal-footer'>"
	            . "<button type='button' class='btn btn-default waves-effect' data-dismiss='modal'>Close</button>"
	            . "<button id='btnedit' onclick='simpan()' type='button' class='btn btn-danger waves-effect waves-light'>Simpan</button>"
	            . "</div>"
	            . "</div>"
	            . "</div>";
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

		$update = $this->hospitalmodel->update($id,$data);
		if ($update) {
			return true;
		} else {
			return false;
		}
	}

}
