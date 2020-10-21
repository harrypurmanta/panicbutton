<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Employeemodel;
use App\Models\Usersmodel;
use App\Models\Pangkatmodel;
use App\Models\Kesatuanmodel;
class employee extends BaseController
{

	protected $employeemodel;
    protected $pangkatmodel;
    protected $kesatuanmodel;
	protected $usersmodel;
	protected $session;

	public function __construct(){
		$this->usersmodel = new Usersmodel();
		$this->employeemodel = new Employeemodel();
        $this->pangkatmodel = new Pangkatmodel();
        $this->kesatuanmodel = new Kesatuanmodel();
		$this->session = \Config\Services::session();
		$this->session->start();
	}

	public function index() {
        if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }

		$data = [
			'title' => 'employee',
			'subtitle' => 'employee',
			//'employee' => $this->employeemodel->findAll()
		];
		return view('employee',$data);
	}

	public function formdaftaremployee() {
        if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }

		$data = [
			'title' => 'employee',
			'subtitle' => 'employee',
			'id' => $this->request->uri->getSegment(3)
		];

		return view('formdaftaremployee',$data);
	}

    public function listmedis() {
        if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }

        $data = [
            'title' => 'employee',
            'subtitle' => 'employee',
            'medis' => $this->employeemodel->getmedis()->getResult()
        ];

        return view('listmedis',$data);
    }

    public function detailmedis(){
        $person_id = $this->request->getPost('id');
        $res = $this->employeemodel->getmedisbyid($person_id)->getResult();
        foreach ($res as $key) {
            if ($key->gender_cd == "l") {
                $gender = "Laki-laki";
            } else {
                $gender = "Perempuan";
            }
            
            $ret = "<div class='modal-dialog modal-xl'>"
               . "<div class='modal-content'>"
               . "<div class='modal-header'>"
               . "<h4 class='modal-title'>Detail</h4>"
                . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"
               . "</div>"
               . "<div class='modal-body'>"
               . "<div class='col-lg-12 col-xlg-3 col-md-5'>
                        <div class='card' style='flex-direction: row !important; '>
                            <div class='col-md-6' style='display:inline-block;'>
                                    <center class='m-t-30'> <img src='../images/persons/$key->image_nm' class='img-circle' width='250' height='250' />
                                        <h4 class='card-title m-t-10'>$key->person_nm</h4>
                                        <h6 class='card-subtitle'>$key->employee_ext_id / $key->pangkat_nm</h6>
                                    </center>

                                <div style='display:inline-block; margin-right: 10px;'>
                                <small class='text-muted'>Kesatuan</small>
                                <h6>$key->kesatuan_nm</h6> 
                                <small class='text-muted db'>Phone</small>
                                <h6>$key->cellphone</h6>
                                </div>
                                <div style='display:inline-block'>
                                <small class='text-muted'>TTL</small>
                                <h6>$key->birth_place, $key->birth_dttm</h6> 
                                <small class='text-muted db'>Jenis Kelamin</small>
                                <h6>$gender</h6>
                                </div>
                                <div style='display:inline-block'>
                                <small class='text-muted'>Alamat</small>
                                <h6>$key->addr_txt</h6>
                                </div>

                            </div>
                        </div>
                    </div>"
               . "</div>"
               . "<div class='modal-footer'>"
               . "<button type='button' class='btn btn-default waves-effect' data-dismiss='modal'>Close</button>"
               . "</div>"
               . "</div>"
               . "</div>";
        }
        return $ret;
    }

	public function cariByname(){
        if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
		$person_nm = $this->request->getPost('person_nm');
		$employee = $this->employeemodel->getBylikenm($person_nm)->getResult();
		if (count($employee)>0) {
			$ret = "";
		      foreach ($employee as $key) {
		        $ret .= "<a onclick='clickpatient($key->person_id)'>"
		                . "<div style='background-color:yellow;padding:5px;border-radius:10px;margin-top: 5px;margin-bottom: 5px; border-left: 4px solid #ccc;'>"
		                . "<p style='display: inline-block; font-size: 14px;font-weight: bold;margin-left:3px;margin-bottom: 0;'>".$key->person_nm."</p>"
		                . "<p style='float:right;display: inline-block;font-size: 14px;font-weight: bold;margin-left:3px;margin-bottom: 0;'>".$key->ext_id."</p>"
		                . "<p style='font-size: 12px;margin-left:3px;margin-bottom: 0;'>".$key->addr_txt."</p>"
		                . "<p style='font-size: 12px;margin-left:3px;margin-bottom: 0;'>".$key->birth_dttm."</p>"
		                . "</div>"
		                . "</a>";
		      }
			
		} else {
			$ret = "<a>"
                . "<div style='background-color:yellow;padding:5px;border-radius:10px;margin-top: 5px;margin-bottom: 5px; border-left: 4px solid #ccc;'>"
                . "<p style='display: inline-block; font-size: 14px;font-weight: bold;margin-left:3px;margin-bottom: 0;'>DATA employee TIDAK ADA . . .</p>"
                . "</div>"
                . "</a>";
		}
		return $ret;

	}

	public function save(){
        if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }

		$person_idx 		= $this->request->getPost('person_id');
		$person_nm 			= $this->request->getPost('person_nm');
		$ext_id 			= $this->request->getPost('ext_id');
		$gender_cd 			= $this->request->getPost('gender_cd');
        $birth_dttm         = $this->request->getPost('birth_dttm');
		$birth_dttm_old 	= $this->request->getPost('birth_dttm_old');
		$birth_place		= $this->request->getPost('birth_place');
		$cellphone 			= $this->request->getPost('cellphone');
		$addr_txt 			= $this->request->getPost('addr_txt');
		$employee_ext_id	= $this->request->getPost('employee_ext_id');
		$pangkat 			= $this->request->getPost('pangkat');
		$kesatuan 			= $this->request->getPost('kesatuan');
		$jabatan_id 		= $this->request->getPost('jabatan');
		$ext_idx 			= $this->employeemodel->getbyext_id($ext_id);
		$datenow            = date('Y-m-d H:i:s');

            if ($birth_dttm == "") {
                $birth_dttmx = $birth_dttm_old;
            } else {
                $birth_dttmx = $birth_dttm;
            }
            
			
			if ($person_idx == "") {
                $fileImg = $this->request->getFile('image_nm');
                if ($fileImg == "") {
                    $image_nm = "";
                } else {
                    $image_nm = $fileImg->getRandomName();
                    $fileImg->move('images/persons/', $image_nm);
                }

				$data = [
					'person_nm' => $person_nm,
					'ext_id' => $ext_id,
					'gender_cd' => $gender_cd,
					'birth_dttm' => $birth_dttmx,
					'birth_place' => $birth_place,
					'cellphone' => $cellphone,
                    'image_path' => 'images/persons/',
                    'image_nm' => $image_nm,
					'addr_txt' => $addr_txt,
					'created_dttm' => $datenow,
					'created_user' => $this->session->user_id
				];
				$person_id = $this->employeemodel->simpan($data);
				if ($person_id !='') {
					$dataemployee = [
					   'person_id' => $person_id,
					   'employee_ext_id' => $employee_ext_id,
					   'pangkat_id' => $pangkat,
					   'kesatuan_id' => $kesatuan,
					   'created_dttm' => $datenow,
					   'created_user' => $this->session->user_id
					];
					$saveEmp = $this->employeemodel->simpanemp($dataemployee);
					echo $person_id;
				} else {
					return false;
				}
			} else {

                $fileImg = $this->request->getFile('image_nm');
                if ($fileImg == "") {
                    $data = [
                        'person_nm' => $person_nm,
                        'ext_id' => $ext_id,
                        'gender_cd' => $gender_cd,
                        'birth_dttm' => $birth_dttmx,
                        'birth_place' => $birth_place,
                        'cellphone' => $cellphone,
                        'addr_txt' => $addr_txt,
                        'update_dttm' => $datenow,
                        'update_user' => $this->session->user_id
                    ];
                } else {
                    $image_nm = $fileImg->getRandomName();
                    $fileImg->move('images/persons/', $image_nm);
                    $data = [
                        'person_nm' => $person_nm,
                        'ext_id' => $ext_id,
                        'gender_cd' => $gender_cd,
                        'birth_dttm' => $birth_dttmx,
                        'birth_place' => $birth_place,
                        'cellphone' => $cellphone,
                        'addr_txt' => $addr_txt,
                        'image_nm' => $image_nm,
                        'update_dttm' => $datenow,
                        'update_user' => $this->session->user_id
                    ];
                }
                
                $dataemployee = [
                    'employee_ext_id' => $employee_ext_id,
                    'pangkat_id' => $pangkat,
                    'kesatuan_id' => $kesatuan,
                    'update_dttm' => $datenow,
                    'update_user' => $this->session->user_id
                ];
				$update = $this->employeemodel->update($person_idx,$data);
                $update = $this->employeemodel->updateemp($person_idx,$dataemployee);
				if ($update) {
					return $person_idx;
				} else {
					return false;
				}
			}
			
			
	}

    public function simpanuser(){
        if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
        $id = $this->request->getPost('id');
        $user_nm = $this->request->getPost('user_nm');
        $pwd = md5($this->request->getPost('pwd0'));
        $user_group = $this->request->getPost('user_group');
        $datenow = date('Y-m-d H:i:s');
        $data = [
            'person_id' => $id,
            'user_nm' => $user_nm,
            'pwd0' => $pwd,
            'user_group' => $user_group,
            'status_cd' => 'normal',
            'created_dttm' => $datenow,
            'created_user' => $this->session->user_id
        ];

        $insertuser = $this->usersmodel->simpan($data);
        if ($insertuser) {
            return true;
        } else {
            return false;
        }
    }

    public function updateuser() {
        if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
        $id = $this->request->getPost('id');
        $uid = $this->request->getPost('uid');
        $user_nm = $this->request->getPost('user_nm');
        $pwd = md5($this->request->getPost('pwd0'));
        $user_group = $this->request->getPost('user_group');
        $datenow = date('Y-m-d H:i:s');
        $data = [
            'user_nm' => $user_nm,
            'pwd0' => $pwd,
            'user_group' => $user_group,
            'status_cd' => 'normal',
            'created_dttm' => $datenow,
            'created_user' => $this->session->user_id
        ];

        $update = $this->usersmodel->update($uid,$data);
        if ($update) {
            return "true";
        } else {
            return "false";
        }
    }

	public function profiletab(){
        if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
		$id = $this->request->getPost('id');
        $pangkat = $this->pangkatmodel->getbyNormal()->getResult();
        $kesatuan = $this->kesatuanmodel->getbyNormal()->getResult();
        $res = $this->employeemodel->getbyId($id)->getResult();
        $optpangkat = "";
        $optkesatuan = "";
        if (count($res)>0) {
             if (count($pangkat) > 0) {
                foreach ($pangkat as $key) {
                    $optpangkat .= "<option ".($key->pangkat_id==$res[0]->pangkat_id?"selected='selected'":"")." value='$key->pangkat_id'>$key->pangkat_nm</option>";
                }
            } else {
                $optpangkat .= "<option>Belum ada data</option>";
            }
            
            if (count($kesatuan) > 0) {
                 foreach ($kesatuan as $k) {
                    $optkesatuan .= "<option ".($k->kesatuan_id==$res[0]->kesatuan_id?"selected='selected'":"")." value='$k->kesatuan_id'>$k->kesatuan_nm</option>";
                }
            } else {
                $optkesatuan .= "<option>Belum ada data</option>";
            }
        }  else {
            if (count($pangkat) > 0) {
                foreach ($pangkat as $key) {
                    $optpangkat .= "<option value='$key->pangkat_id'>$key->pangkat_nm</option>";
                }
            } else {
                $optpangkat .= "<option>Belum ada data</option>";
            }
            
            if (count($kesatuan) > 0) {
                 foreach ($kesatuan as $k) {
                    $optkesatuan .= "<option value='$k->kesatuan_id'>$k->kesatuan_nm</option>";
                }
            } else {
                $optkesatuan .= "<option>Belum ada data</option>";
            }
        }
		$ret ="";
		if (count($res)>0) {
        $ret = "";
        foreach ($res as $key) {
        list($dt,$dd) = explode(" ",$key->birth_dttm);
        $newDate = date("m-d-Y", strtotime($dt));
        $date = str_replace('-','/',$newDate);

        $ret .= "<div class='p-20'>"
                . "<form action='#' class='form-horizontal'>"
                . "<div class='form-body'>"
                . "<h3 class='box-title'>Person Info</h3>"
                . "<hr class='m-t-0 m-b-40'>"
                . "<div class='row'>"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Nama Lengkap</label>"
                . "<div class='col-md-9'>"
                . "<input type='hidden' value='$id' id='person_id'/>"
                . "<input type='text' class='form-control' id='person_nm' value='$key->person_nm'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Nomor Identitas</label>"
                . "<div class='col-md-9'>"
                . "<input type='text' class='form-control' id='ext_id' value='$key->ext_id'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>NRP/NIP</label>"
                . "<div class='col-md-9'>"
                . "<input type='text' class='form-control' id='employee_ext_id' value='$key->employee_ext_id'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Pangkat</label>"
                . "<div class='col-md-9'>"
                . "<select class='form-control' id='pangkat'>"
                . "$optpangkat"
                . "</select>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Kesatuan</label>"
                . "<div class='col-md-9'>"
                . "<select class='form-control' id='kesatuan'>"
                . "$optkesatuan"
                . "</select>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Jenis Kelamin</label>"
                . "<div class='col-md-9'>"
                . "<select class='form-control custom-select' id='gender_cd'>"
                . "<option ".($key->gender_cd=='m'?" selected='selected'":"")." value='m'>Laki-laki</option>"
                . "<option ".($key->gender_cd=='f'?" selected='selected'":"")." value='f'>Perempuan</option>"
                . "</select>"
                . "</div>"
                . "</div>"
                . "</div>"

                . "</div>"
                . "<!--/row-->"
                . "<div class='row'>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Tanggal Lahir</label>"
                . "<div class='col-md-9'>"
                . "<span class='control-label'>$date</span>"
                . "<input type='hidden' class='form-control' id='birth_dttm_old' value='$date'>"
                . "<input type='date' class='form-control' id='birth_dttm' value='$date'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Tempat Lahir</label>"
                . "<div class='col-md-9'>"
                . "<input type='text' class='form-control' id='birth_place' value='$key->birth_place'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "</div>"
                . "<!--/row-->"
                . "<div class='row'>"
                
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>No. Telp</label>"
                . "<div class='col-md-9'>"
                . "<input type='text' class='form-control' id='cellphone' value='$key->cellphone'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Alamat</label>"
                . "<div class='col-md-9'>"
                . "<textarea type='text' class='form-control' id='addr_txt'>$key->addr_txt</textarea>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "</div>"
                . "<div class='row'>"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Avatar</label>"
                . "<div class='col-md-9'>"
                . "<input type='file' class='form-control' id='image_nm'/>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-4'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Avatar</label>"
                . "<div style='width:250px;height:250px;border:2px solid #e2e2e2;border-radius: 5px;' class='col-md-7'>";
                if ($key->image_nm == "") {
                    $ret .= "<img src='../../img/no_image.png'/>";
                } else {
                    $ret .= "<img style='width:250px;height:250px; border-radius: 10px;' src='../../images/persons/$key->image_nm'/>";
                }
                $ret .= "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<hr>"
                . "<div class='form-actions'>"
                . "<div class='row'>"
                . "<div class='col-md-6'>"
                . "<div class='row'>"
                . "<div class='col-md-offset-3 col-md-9'>"
                . "<button onclick='simpan()' type='button' class='btn btn-success'>Submit</button> " 
                . "<button type='button' class='btn btn-inverse'>Cancel</button>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<div class='col-md-6'> </div>"
                . "</div>"
                . "</div>"
                . "</form>"
                . "</div>";

            }
		} else {
            $ret .= "<div class='p-20'>"
                . "<form action='#' class='form-horizontal'>"
                . "<div class='form-body'>"
                . "<h3 class='box-title'>Person Info</h3>"
                . "<hr class='m-t-0 m-b-40'>"
                . "<div class='row'>"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Nama Lengkap</label>"
                . "<div class='col-md-9'>"
                . "<input type='hidden' value='$id' id='person_id'/>"
                . "<input type='text' class='form-control' id='person_nm'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Nomor Identitas</label>"
                . "<div class='col-md-9'>"
                . "<input type='text' class='form-control' id='ext_id'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>NRP/NIP</label>"
                . "<div class='col-md-9'>"
                . "<input type='text' class='form-control' id='employee_ext_id'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Pangkat</label>"
                . "<div class='col-md-9'>"
                . "<select class='form-control' id='pangkat'>"
                . "$optpangkat"
                . "</select>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Kesatuan</label>"
                . "<div class='col-md-9'>"
                . "<select class='form-control' id='kesatuan'>"
                . "$optkesatuan"
                . "</select>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Jenis Kelamin</label>"
                . "<div class='col-md-9'>"
                . "<select class='form-control custom-select' id='gender_cd'>"
                . "<option value='m'>Laki-laki</option>"
                . "<option value='f'>Perempuan</option>"
                . "</select>"
                . "</div>"
                . "</div>"
                . "</div>"

                . "</div>"
                . "<!--/row-->"
                . "<div class='row'>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Tanggal Lahir</label>"
                . "<div class='col-md-9'>"
                . "<span class='control-label'></span>"
                . "<input type='date' class='form-control' id='birth_dttm'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Tempat Lahir</label>"
                . "<div class='col-md-9'>"
                . "<input type='text' class='form-control' id='birth_place'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "</div>"
                . "<!--/row-->"
                . "<div class='row'>"
                
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>No. Telp</label>"
                . "<div class='col-md-9'>"
                . "<input type='text' class='form-control' id='cellphone'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Alamat</label>"
                . "<div class='col-md-9'>"
                . "<textarea type='text' class='form-control' id='addr_txt'></textarea>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "</div>"
                . "<div class='row'>"
                . "<div class='col-md-6'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Avatar</label>"
                . "<div class='col-md-9'>"
                . "<input type='file' class='form-control' id='image_nm'/>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-4'>"
                . "<div class='form-group row'>"
                . "<label class='control-label text-right col-md-3'>Avatar</label>"
                . "<div style='width:250px;height:250px;border:2px solid #e2e2e2;border-radius: 5px;' class='col-md-7'>"
                . "<img src='../../img/no_image.png'/>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<hr>"
                . "<div class='form-actions'>"
                . "<div class='row'>"
                . "<div class='col-md-6'>"
                . "<div class='row'>"
                . "<div class='col-md-offset-3 col-md-9'>"
                . "<button onclick='simpan()' type='button' class='btn btn-success'>Submit</button> " 
                . "<button type='button' class='btn btn-inverse'>Cancel</button>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<div class='col-md-6'> </div>"
                . "</div>"
                . "</div>"
                . "</form>"
                . "</div>";

		}
         return $ret;
        
	}

	public function accounttab(){
        if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
		$id = $this->request->getVar('id');
		$res = $this->usersmodel->getbyId($id)->getResult();
		$ret = "";
	foreach ($res as $key) {

		if ($key->user_nm!='') {
		$ret = "<div row'>"
                . "<div class='col-md-12'>"
                . "<form action='' class='form-horizontal'>"
                . "<div class='form-body'>"
                . "<h3 class='box-title'>Users Info</h3>"
                . "<hr class='m-t-0 m-b-40'>"
                . "<div class='row'>"
                . "<div class='col-md-6'>"
                . "<div class='form-group'>"
                . "<label class='control-label text-right col-md-3'>Username</label>"
                . "<div class='col-md-8'>"
                . "<input type='hidden' value='$id' id='person_id'/>"
                . "<input type='text' class='form-control' id='user_nm' value='$key->user_nm'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group'>"
                . "<label class='control-label text-right col-md-3'>Password</label>"
                . "<div class='col-md-8'>"
                . "<input type='password' class='form-control' id='ext_id' value='$key->pwd0'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-4'>"
                . "<div class='form-group'>"
                . "<label class='control-label text-right col-md-3'>Level</label>"
                . "<div class='col-md-8'>"
                . "<select  class='form-control' id='user_group'>"
                . "<option ".($key->user_group=='admin'?"selected='selected'":"")." value='admin'>Admin</option>"
                . "<option ".($key->user_group=='employee'?"selected='selected'":"")." value='employee'>Pegawai</option>"
                . "<option ".($key->user_group=='medic'?"selected='selected'":"")." value='medic'>Medis</option>"
                . "<option ".($key->user_group=='cc'?"selected='selected'":"")." value='cc'>Command Center</option>"
                . "</select>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
               
                . "<!--/span-->"
                . "</div>"
                . "</div>"
                . "<hr>"
                . "<div class='form-actions'>"
                . "<div class='row'>"
                . "<div class='col-md-offset-3 col-md-9'>"
                . "<button onclick='updateuser($id,$key->user_id)' type='button' class='btn btn-success'>Submit</button> " 
                . "<button type='button' class='btn btn-inverse'>Cancel</button>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</form>"
                . "</div>"
                . "</div>"
                . "</div>";
        	
			} else {
				$ret = "<button onclick='formtambahuser($id)'>Tambah User</button>";
			}
		}
         return $ret;
        
	}

    

	public function formtambahuser(){
        if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
		$id = $this->request->getVar('id');

		$ret = "<div class='p-20'>"
                . "<form action='#' class='form-horizontal'>"
                . "<div class='form-body'>"
                . "<h3 class='box-title'>Person Info</h3>"
                . "<hr class='m-t-0 m-b-40'>"
                . "<div class='row'>"
                . "<div class='col-md-6'>"
                . "<div class='form-group'>"
                . "<label class='control-label text-right col-md-3'>Username</label>"
                . "<div class='col-md-9'>"
                . "<input type='hidden' value='$id' id='person_id'/>"
                . "<input type='text' class='form-control' id='user_nm'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group'>"
                . "<label class='control-label text-right col-md-3'>Password</label>"
                . "<div class='col-md-9'>"
                . "<input type='password' class='form-control' id='pwd0'>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "<div class='col-md-6'>"
                . "<div class='form-group'>"
                . "<label class='control-label text-right col-md-3'>Level</label>"
                . "<div class='col-md-9'>"
                . "<select  class='form-control' id='user_group'>"
                . "<option value='admin'>Admin</option>"
                . "<option value='Employee'>Pegawai</option>"
                . "<option value='Medic'>Medis</option>"
                . "<option value='cc'>Command Center</option>"
                . "</select>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<!--/span-->"
                . "</div>"
                . "</div>"
                . "<hr>"
                . "<div class='form-actions'>"
                . "<div class='row'>"
                . "<div class='col-md-6'>"
                . "<div class='row'>"
                . "<div class='col-md-offset-3 col-md-9'>"
                . "<button onclick='simpanuser($id)' type='button' class='btn btn-success'>Submit</button> " 
                . "<button type='button' class='btn btn-inverse'>Cancel</button>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<div class='col-md-6'> </div>"
                . "</div>"
                . "</div>"
                . "</form>"
                . "</div>";
        
		
         return $ret;
        
	}
	

}
