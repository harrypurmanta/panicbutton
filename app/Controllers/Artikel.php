<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Artikelmodel;

class artikel extends BaseController
{

	protected $artikelmodel;
	public function __construct(){
		$this->artikelmodel = new Artikelmodel();
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
			'artikel' => $this->artikelmodel->getbynormal()
		];
		return view('artikel',$data);
	}

	public function tambahdata() {
		$keahlian = $this->artikelmodel->getkeahlian()->getResult();
		$optkeahlian = "";
		if (count($keahlian)>0) {
			foreach ($keahlian as $key) {
				$optkeahlian .= "<option value='$key->keahlian_id'>$key->keahlian_nm</option>";
			}
		} else {
				$optkeahlian .= "<option>Belum ada data</option>";
		}
		

		$ret = "<div class='modal-dialog modal-lg'>"
	            . "<div class='modal-content'>"
	            . "<div class='modal-header'>"
	            . "<h4 class='modal-title'>Silahkan Tambah Data</h4>"
	             . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"
	            . "</div>"
	            . "<div class='modal-body'>"
	            . "<form class='forms' id='forms' action='post' enctype='multipart/form-data'>"
	            . "<div class='form-group'>"
	            . "<label for='recipient-name' class='control-label'>Judul Artikel</label>"
	            . "<input type='text' class='form-control' id='artikel_nm'>"
	            . "</div>"
	            . "<div class='form-group row'>"
	            . "<div class='col-5'>"
	            . "<label for='recipient-name' class='control-label'>Kategori</label>"
	            . "<select class='form-control' id='category_id'>"
	            . "$optkeahlian"
	            . "</select>"
	            . "</div>"
	            . "<div class='col-5'>"
	            . "<label for='recipient-name' class='control-label'>Gambar</label>"
	            . "<input type='file' class='form-control' id='artikel_img'>"
	            . "</div>"
	            . "</div>"
	            . "<div class='form-group'>"
	            . "<label for='recipient-name' class='control-label'>Description</label>"
	            . "<textarea class='form-control' id='description'></textarea>"
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

		$artikel_nm  = $this->request->getPost('artikel_nm');
		$category_id = $this->request->getPost('category_id');
		$description = $this->request->getPost('description');
		$datenow = date('Y-m-d H:i:s');
        
        if ($fileImg = $this->request->getFile('artikel_img')) {
        	$img = $fileImg->getRandomName();
        	$fileImg->move('images/artikel/', $img);
        	$data = [
				'artikel_nm' => $artikel_nm,
				'keahlian_id' => $category_id,	
				'description' => $description,
				'artikel_img' => $img,
				'status_cd' => 'normal',
				'created_dttm' => $datenow,
				'created_user' => $this->session->user_id
			];

			$save = $this->artikelmodel->save($data);
			if ($save) {
				return "true";
			} else {
				return "false";
			}
        } else {
        	return "falseimg";
        }	
	}

	public function update(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
        $datenow = date('Y-m-d H:i:s');
		$id = $this->request->getPost('id');
		$artikel_nm  = $this->request->getPost('artikel_nm');
		$category_id = $this->request->getPost('category_id');
		$description = $this->request->getPost('description');

		if ($fileImg = $this->request->getFile('artikel_img')) {
        	$img = $fileImg->getRandomName();
        	$fileImg->move('images/artikel/', $img);
        	$data = [
				'artikel_nm' => $artikel_nm,
				'keahlian_id' => $category_id,	
				'description' => $description,
				'artikel_img' => $img,
				'status_cd' => 'normal',
				'updated_dttm' => $datenow,
				'updated_user' => $this->session->user_id
			];

        } else {
        	$data = [
				'artikel_nm' => $artikel_nm,
				'keahlian_id' => $category_id,	
				'description' => $description,
				'status_cd' => 'normal',
				'updated_dttm' => $datenow,
				'updated_user' => $this->session->user_id
			];
        }


			$update = $this->artikelmodel->update($id,$data);
			if ($update) {
				return "true";
			} else {
				return "false";
			}
		
	}

	public function formedit(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
        $optkeahlian = "";
		$artikel_id = $this->request->getVar('id');
		$keahlian = $this->artikelmodel->getkeahlian()->getResult();
		$res = $this->artikelmodel->getbyid($artikel_id)->getResult();
		if (count($res)>0) {

			if (count($keahlian)>0) {
				foreach ($keahlian as $key) {
					$optkeahlian .= "<option ".($key->keahlian_id==$res[0]->keahlian_id?"selected='selected'":"")." value='$key->keahlian_id'>$key->keahlian_nm</option>";
				}
			} else {
					$optkeahlian .= "<option>Belum ada data</option>";
			}
		
		foreach ($res as $key) {
			$ret = "<div class='modal-dialog modal-lg'>"
	            . "<div class='modal-content'>"
	            . "<div class='modal-header'>"
	            . "<h4 class='modal-title'>Silahkan Tambah Data</h4>"
	             . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"
	            . "</div>"
	            . "<div class='modal-body'>"
	            . "<form class='forms' id='forms' action='post' enctype='multipart/form-data'>"
	            . "<div class='form-group'>"
	            . "<label for='recipient-name' class='control-label'>Judul Artikel</label>"
	            . "<input type='text' class='form-control' id='artikel_nm' value='$key->artikel_nm'>"
	            . "</div>"
	            . "<div class='form-group row'>"
	            . "<div class='col-5'>"
	            . "<label for='recipient-name' class='control-label'>Kategori</label>"
	            . "<select class='form-control' id='category_id'>"
	            . "$optkeahlian"
	            . "</select>"
	            . "</div>"
	            . "<div class='col-5'>"
	            . "<label for='recipient-name' class='control-label'>Gambar</label>"
	            . "<input type='file' class='form-control' id='artikel_img'>"
	            . "<img src='img/artikel/$key->artikel_img' style='height:150px;widht:150px;margin-top:10px;'/>"
	            . "</div>"
	            . "</div>"
	            . "<div class='form-group'>"
	            . "<label for='recipient-name' class='control-label'>Description</label>"
	            . "<textarea class='form-control' id='description'>$key->description</textarea>"
	            . "</div>"
	            . "</div>"
	            . "<div class='modal-footer'>"
	            . "<button type='button' class='btn btn-default waves-effect' data-dismiss='modal'>Close</button>"
	            . "<button onclick='update($key->artikel_id)' type='button' class='btn btn-danger waves-effect waves-light'>Simpan</button>"
	            . "</form>"
	            . "</div>"
	            . "</div>"
	            . "</div>";
		}
		
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

		$update = $this->artikelmodel->update($id,$data);
		if ($update) {
			return true;
		} else {
			return false;
		}
	}

}
