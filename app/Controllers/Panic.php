<?php namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\Panicmodel;

class Panic extends BaseController
{
	protected $panicmodel;
	public function __construct(){
		$this->panicmodel = new Panicmodel();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	public function history(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
		$data = [
			'title' => 'Panic Dashboard',
			'subtitle' => 'History',
			'panic' => $this->panicmodel->getbynormal()
		];
		// echo json_encode($this->panicmodel->getbynormal()->getResult());
		return view('panic',$data);
	}

	public function getlistwaiting() {
		$res = $this->panicmodel->getbywaiting()->getResult();
		if (count($res)>0) {
			$ret = "<div class='modal-dialog'>"
	            . "<div class='modal-content'>"
	            . "<div class='modal-header'>"
	            . "<h4 class='modal-title'>Emergensi</h4>"
	             . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>"
	            . "</div>"
	            . "<div class='modal-body'>";
		      foreach ($res as $key) {
		        $ret .= "<a style='width: 100%;' class='btn btn-click' onclick='clickpanicpatient($key->person_idpanic)'>"
		                . "<div class='quadrat' style='padding:5px;border-radius:10px;margin-top: 5px;margin-bottom: 5px; border-left: 4px solid #ccc;'>"
		                . "<p style='font-size: 14px;font-weight: bold;margin-left:3px;margin-bottom: 0;'>".$key->pangkatpanic." ".$key->userpanic."</p>"
		                . "<p style='font-size: 14px;font-weight: bold;margin-left:3px;margin-bottom: 0;'>".$key->nrppanic."</p>"
		                . "<p style='font-size: 12px;margin-left:3px;margin-bottom: 0;'>".$key->addrpanic."</p>"
		                . "</div>"
		                . "</a>";
	            
		      }
		    $ret .= "</div>"
	            . "</div>";
			return $ret;
		} else {
			return "false";
		}
		
	}

	public function detail() {
		$id = $this->request->getPost('id');
		$res = $this->panicmodel->getbyid($id)->getResult();
		if (count($res)>0) {
			foreach ($res as $key) {
				if ($key->gender_cd == "l") {
					$gender = "Laki-laki";
				} else {
					$gender = "Perempuan";
				}

				if ($key->birth_dttm == "0000-00-00 00:00:00") {
					$birth_dttm = $key->birth_dttm;
				} else {
					$birth_dttm = panjang($key->birth_dttm);
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
                                	    <h4 class='card-title m-t-10'>$key->userpanic</h4>
                                	    <h6 class='card-subtitle'>$key->nrppanic / $key->pangkatpanic</h6>
                                	</center>

                            	<div style='display:inline-block; margin-right: 10px;'>
                            	<small class='text-muted'>Kesatuan</small>
                                <h6>$key->kesatuanpanic</h6> 
                                <small class='text-muted db'>Phone</small>
                                <h6>$key->phonepanic</h6>
                            	</div>
                            	<div style='display:inline-block'>
                            	<small class='text-muted'>TTL</small>
                                <h6>$key->birth_place, ".$birth_dttm."</h6> 
                                <small class='text-muted db'>Jenis Kelamin</small>
                                <h6>$gender</h6>
                            	</div>
                            	<div style='display:inline-block'>
                            	<small class='text-muted'>Alamat</small>
                                <h6>$key->addrpanic</h6>
                            	</div>

                            </div>
                            <div class='col-md-6' style='display:inline-block;'> 
                            	<small class='text-muted'>Responder (Medic) </small>
                                <h6>$key->userrespon</h6> 
                                <small class='text-muted p-t-10 db'>Phone</small>
                                <h6>$key->phonerespon</h6> 
                                <small class='text-muted p-t-10 db'>Address panic</small>
                                <div class='map-box'>
                                <iframe src='https://maps.google.com/maps?q=$key->latitude,$key->longitude&z=15&output=embed&zoom=30' width='100%' height='450' frameborder='0' style='border:0;' allowfullscreen='' aria-hidden='false' tabindex='0'></iframe>
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
		} else {
			# code...
		}
	}

	public function hapus() {
		$id = $this->request->getPost('id');
		$data = [
            'nullified_user' => session()->get('user_id'),
            'nullified_dttm' => date('Y-m-d H:i:s'),
            'status_cd'     => 'nullified',
        ];

		return $this->panicmodel->update($id,$data);
	}
}