<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PanicTransaction extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Panictransaction');
        $this->load->library('dateFunction/date');
        $this->load->model('M_pushnotif');
    }

    public function getPanicWaiting()
    {
        $status_respon = $this->uri->segment(3);
        $user_id = $this->uri->segment(4);
        $res = $this->M_Panictransaction->getPanicWaiting($status_respon, $user_id);
        $jumlah_data = count($res);
        if (count($res) > 0) {
            foreach ($res as $data) {
                $created_dttm = $this->date->panjang($data->created_dttm);
                $created_time = date("H:i", strtotime($data->created_dttm));
                $gender_cd = $data->gender_cd;
                if ($gender_cd == 'l') {
                    $gender_cd = 'Laki-laki';
                } else {
                    $gender_cd = 'Perempuan';
                }
                $image_path = $data->image_path;
                if ($image_path == '') {
                    $image_path = '/images/persons/';
                }
                $image_nm = $data->image_nm;
                if ($image_nm == '') {
                    if ($gender_cd == 'Laki-laki') {
                        $image_nm = 'male.png';
                    } else {
                        $image_nm = 'female.png';
                    }
                } else {
                    $image_nm = $image_nm;
                }

                $ret[] = array(
                    'message' => 'Sukses',
                    'panic_transc_id' => $data->panic_transc_id,
                    'userpanic_id' =>  $data->userpanic_id,
                    'latitude' =>  $data->latitude,
                    'longitude' =>  $data->longitude,
                    'created_dttm' =>  $created_dttm,
                    'created_time' =>  $created_time,
                    'person_id' =>  $data->person_id,
                    'person_nm' =>  $data->person_nm,
                    'gender_cd' =>  $gender_cd,
                    'cellphone' =>  $data->cellphone,
                    'image_path' =>  $image_path,
                    'image_nm' =>  $image_nm,
                    'employee_id' =>  $data->employee_id,
                    'employee_ext_id' =>  $data->employee_ext_id,
                    'pangkat_nm' =>  $data->pangkat_nm,
                    'kesatuan_nm' =>  $data->kesatuan_nm,
                    'status_respon' =>  $data->status_respon,
                    'jumlah_data' =>  $jumlah_data,
                );
            }
        } else {
            $ret[] = array(
                'message' => 'Empty'
            );
        }
        echo json_encode($ret);
    }

    public function getPanicRiwayat()
    {
        $user_id = $this->uri->segment(3);
        $res = $this->M_Panictransaction->getPanicRiwayat($user_id);
        $jumlah_data = count($res);
        if (count($res) > 0) {
            foreach ($res as $data) {
                $created_dttm = $this->date->panjang($data->created_dttm);
                $created_time = date("H:i", strtotime($data->created_dttm));
                $gender_cd = $data->gender_cd;
                if ($gender_cd == 'l') {
                    $gender_cd = 'Laki-laki';
                } else {
                    $gender_cd = 'Perempuan';
                }

                $gender_cd_respon = $data->gender_cd_respon;
                if ($gender_cd_respon == 'l') {
                    $gender_cd_respon = 'Laki-laki';
                } else {
                    $gender_cd_respon = 'Perempuan';
                }
                $image_path = $data->image_path;
                if ($image_path == '') {
                    $image_path = '/images/persons/';
                }
                $image_nm = $data->image_nm;
                if ($image_nm == '') {
                    if ($gender_cd == 'Laki-laki') {
                        $image_nm = 'male.png';
                    } else {
                        $image_nm = 'female.png';
                    }
                } else {
                    $image_nm = $image_nm;
                }
                $image_path_respon = $data->image_path_respon;
                if ($image_path_respon == '') {
                    $image_path_respon = '/images/persons/';
                }
                $image_nm_respon = $data->image_nm_respon;
                if ($image_nm_respon == '') {
                    if ($gender_cd == 'Laki-laki') {
                        $image_nm_respon = 'male.png';
                    } else {
                        $image_nm_respon = 'female.png';
                    }
                } else {
                    $image_nm_respon = $image_nm_respon;
                }

                $ret[] = array(
                    'message' => 'Sukses',
                    'panic_transc_id' => $data->panic_transc_id,
                    'userpanic_id' =>  $data->userpanic_id,
                    'latitude' =>  $data->latitude,
                    'longitude' =>  $data->longitude,
                    'created_dttm' =>  $created_dttm,
                    'created_time' =>  $created_time,
                    'person_id' =>  $data->person_id,
                    'person_nm' =>  $data->person_nm,
                    'gender_cd' =>  $gender_cd,
                    'cellphone' =>  $data->cellphone,
                    'image_path' =>  $image_path,
                    'image_nm' =>  $image_nm,
                    'employee_id' =>  $data->employee_id,
                    'employee_ext_id' =>  $data->employee_ext_id,
                    'pangkat_nm' =>  $data->pangkat_nm,
                    'kesatuan_nm' =>  $data->kesatuan_nm,
                    'status_respon' =>  $data->status_respon,
                    'jumlah_data' =>  $jumlah_data,
                    'person_nm_respon' => $data->person_nm_respon,
                    'pangkat_nm_respon' => $data->pangkat_nm_respon,
                    'image_path_respon' =>  $image_path_respon,
                    'image_nm_respon' =>  $image_nm_respon,
                    'kesatuan_nm_respon' =>  $data->kesatuan_nm_respon,
                    'employee_ext_id_respon' =>  $data->employee_ext_id_respon,
                    'cellphone_respon' =>  $data->cellphone_respon,
                );
            }
        } else {
            $ret[] = array(
                'message' => 'Gagal'
            );
        }
        echo json_encode($ret);
    }

    public function getPanicRiwayatId()
    {
        $panic_transc_id = $this->uri->segment(3);
        $res = $this->M_Panictransaction->getPanicRiwayatId($panic_transc_id);
        $jumlah_data = count($res);
        if (count($res) > 0) {
            foreach ($res as $data) {
                $created_dttm = $this->date->panjang($data->created_dttm);
                $created_time = date("H:i", strtotime($data->created_dttm));
                $gender_cd = $data->gender_cd;
                if ($gender_cd == 'l') {
                    $gender_cd = 'Laki-laki';
                } else {
                    $gender_cd = 'Perempuan';
                }

                $gender_cd_respon = $data->gender_cd_respon;
                if ($gender_cd_respon == 'l') {
                    $gender_cd_respon = 'Laki-laki';
                } else {
                    $gender_cd_respon = 'Perempuan';
                }
                $image_path = $data->image_path;
                if ($image_path == '') {
                    $image_path = '/images/persons/';
                }
                $image_nm = $data->image_nm;
                if ($image_nm == '') {
                    if ($gender_cd == 'Laki-laki') {
                        $image_nm = 'male.png';
                    } else {
                        $image_nm = 'female.png';
                    }
                } else {
                    $image_nm = $image_nm;
                }
                $image_path_respon = $data->image_path_respon;
                if ($image_path_respon == '') {
                    $image_path_respon = '/images/persons/';
                }
                $image_nm_respon = $data->image_nm_respon;
                if ($image_nm_respon == '') {
                    if ($gender_cd == 'Laki-laki') {
                        $image_nm_respon = 'male.png';
                    } else {
                        $image_nm_respon = 'female.png';
                    }
                } else {
                    $image_nm_respon = $image_nm_respon;
                }

                $ret = array(
                    'message' => 'Sukses',
                    'panic_transc_id' => $data->panic_transc_id,
                    'userpanic_id' =>  $data->userpanic_id,
                    'latitude' =>  $data->latitude,
                    'longitude' =>  $data->longitude,
                    'created_dttm' =>  $created_dttm,
                    'created_time' =>  $created_time,
                    'person_id' =>  $data->person_id,
                    'person_nm' =>  $data->person_nm,
                    'gender_cd' =>  $gender_cd,
                    'cellphone' =>  $data->cellphone,
                    'image_path' =>  $image_path,
                    'image_nm' =>  $image_nm,
                    'employee_id' =>  $data->employee_id,
                    'employee_ext_id' =>  $data->employee_ext_id,
                    'pangkat_nm' =>  $data->pangkat_nm,
                    'kesatuan_nm' =>  $data->kesatuan_nm,
                    'status_respon' =>  $data->status_respon,
                    'jumlah_data' =>  $jumlah_data,
                    'person_nm_respon' => $data->person_nm_respon,
                    'pangkat_nm_respon' => $data->pangkat_nm_respon,
                    'image_path_respon' =>  $image_path_respon,
                    'image_nm_respon' =>  $image_nm_respon,
                    'kesatuan_nm_respon' =>  $data->kesatuan_nm_respon,
                    'employee_ext_id_respon' =>  $data->employee_ext_id_respon,
                    'cellphone_respon' =>  $data->cellphone_respon,
                );
            }
        } else {
            $ret = array(
                'message' => 'Gagal'
            );
        }
        echo json_encode($ret);
    }

    public function getResponRiwayat()
    {
        $user_id = $this->uri->segment(3);
        $res = $this->M_Panictransaction->getResponRiwayat($user_id);
        $jumlah_data = count($res);
        if (count($res) > 0) {
            foreach ($res as $data) {
                $created_dttm = $this->date->panjang($data->created_dttm);
                $created_time = date("H:i", strtotime($data->created_dttm));
                $gender_cd = $data->gender_cd;
                if ($gender_cd == 'l') {
                    $gender_cd = 'Laki-laki';
                } else {
                    $gender_cd = 'Perempuan';
                }

                $gender_cd_respon = $data->gender_cd_respon;
                if ($gender_cd_respon == 'l') {
                    $gender_cd_respon = 'Laki-laki';
                } else {
                    $gender_cd_respon = 'Perempuan';
                }
                $image_path = $data->image_path;
                if ($image_path == '') {
                    $image_path = '/images/persons/';
                }
                $image_nm = $data->image_nm;
                if ($image_nm == '') {
                    if ($gender_cd == 'Laki-laki') {
                        $image_nm = 'male.png';
                    } else {
                        $image_nm = 'female.png';
                    }
                } else {
                    $image_nm = $image_nm;
                }
                $image_path_respon = $data->image_path_respon;
                if ($image_path_respon == '') {
                    $image_path_respon = '/images/persons/';
                }
                $image_nm_respon = $data->image_nm_respon;
                if ($image_nm_respon == '') {
                    if ($gender_cd == 'Laki-laki') {
                        $image_nm_respon = 'male.png';
                    } else {
                        $image_nm_respon = 'female.png';
                    }
                } else {
                    $image_nm_respon = $image_nm_respon;
                }

                $ret[] = array(
                    'message' => 'Sukses',
                    'panic_transc_id' => $data->panic_transc_id,
                    'userpanic_id' =>  $data->userpanic_id,
                    'latitude' =>  $data->latitude,
                    'longitude' =>  $data->longitude,
                    'created_dttm' =>  $created_dttm,
                    'created_time' =>  $created_time,
                    'person_id' =>  $data->person_id,
                    'person_nm' =>  $data->person_nm,
                    'gender_cd' =>  $gender_cd,
                    'cellphone' =>  $data->cellphone,
                    'image_path' =>  $image_path,
                    'image_nm' =>  $image_nm,
                    'employee_id' =>  $data->employee_id,
                    'employee_ext_id' =>  $data->employee_ext_id,
                    'pangkat_nm' =>  $data->pangkat_nm,
                    'kesatuan_nm' =>  $data->kesatuan_nm,
                    'status_respon' =>  $data->status_respon,
                    'jumlah_data' =>  $jumlah_data,
                    'person_nm_respon' => $data->person_nm_respon,
                    'pangkat_nm_respon' => $data->pangkat_nm_respon,
                    'image_path_respon' =>  $image_path_respon,
                    'image_nm_respon' =>  $image_nm_respon,
                    'kesatuan_nm_respon' =>  $data->kesatuan_nm_respon,
                    'employee_ext_id_respon' =>  $data->employee_ext_id_respon,
                    'cellphone_respon' =>  $data->cellphone_respon,
                );
            }
        } else {
            $ret[] = array(
                'message' => 'Gagal'
            );
        }
        echo json_encode($ret);
    }

    public function getPanicId()
    {
        $panic_transc_id = $this->uri->segment(3);
        $res = $this->M_Panictransaction->getPanicId($panic_transc_id);
        $jumlah_data = count($res);
        if (count($res) > 0) {
            foreach ($res as $data) {
                $created_dttm = $this->date->panjang($data->created_dttm);
                $created_time = date("H:i", strtotime($data->created_dttm));
                $gender_cd = $data->gender_cd;
                if ($gender_cd == 'l') {
                    $gender_cd = 'Laki-laki';
                } else {
                    $gender_cd = 'Perempuan';
                }
                $image_path = $data->image_path;
                if ($image_path == '') {
                    $image_path = '/images/persons/';
                }
                $image_nm = $data->image_nm;
                if ($image_nm == '') {
                    if ($gender_cd == 'Laki-laki') {
                        $image_nm = 'male.png';
                    } else {
                        $image_nm = 'female.png';
                    }
                } else {
                    $image_nm = $image_nm;
                }
                $cellphone = $data->cellphone;
                if ($cellphone == '') {
                    $cellphone = '-';
                }

                $ret = array(
                    'message' => 'Sukses',
                    'panic_transc_id' => $data->panic_transc_id,
                    'userpanic_id' =>  $data->userpanic_id,
                    'latitude' =>  $data->latitude,
                    'longitude' =>  $data->longitude,
                    'created_dttm' =>  $created_dttm,
                    'created_time' =>  $created_time,
                    'person_id' =>  $data->person_id,
                    'person_nm' =>  $data->person_nm,
                    'gender_cd' =>  $gender_cd,
                    'cellphone' =>  $cellphone,
                    'image_path' =>  $image_path,
                    'image_nm' =>  $image_nm,
                    'employee_id' =>  $data->employee_id,
                    'employee_ext_id' =>  $data->employee_ext_id,
                    'pangkat_nm' =>  $data->pangkat_nm,
                    'kesatuan_nm' =>  $data->kesatuan_nm,
                    'status_respon' =>  $data->status_respon,
                    'jumlah_data' =>  $jumlah_data,
                );
            }
        } else {
            $ret = array(
                'message' => 'Gagal'
            );
        }
        echo json_encode($ret);
    }

    public function createPanic()
    {
        $userpanic_id = $this->uri->segment(3);
        $latitude = $this->uri->segment(4);
        $longitude = $this->uri->segment(5);
        $created_dttm = date('Y-m-d H:i:s');

        $data = array(
            'userpanic_id' => $userpanic_id,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'created_dttm' => $created_dttm,
            'created_user' => $userpanic_id,
        );

        $res = $this->M_Panictransaction->setPanic($data);
        if ($res['response'] == true) {
            $getAccount = $this->M_pushnotif->getAccount($userpanic_id);
            foreach ($getAccount as $data) {
                $notif =  $this->M_pushnotif->sendMessagePanic($data->user_id_device);
            }
            $ret = array(
                'message' => 'Sukses',
                'panic_id' => $res['insertId']
            );
        } else {
            $ret = array(
                'message' => 'Gagal'
            );
        }
        echo json_encode($ret);
    }

    public function createPanicResponse()
    {
        $panic_transc_id = $this->uri->segment(3);
        $userrespon_id = $this->uri->segment(4);
        $userpanic_id = $this->uri->segment(5);
        $update_dttm = $this->date->dateNow();

        $data = array(
            'userrespon_id' => $userrespon_id,
            'update_dttm' => $update_dttm,
            'update_user' => $userrespon_id,
            'status_respon' => 'confirm',
        );


        $res = $this->M_Panictransaction->setPanicResponse($data, $panic_transc_id);
        if ($res == true) {
            $getAccount = $this->M_pushnotif->getAccountRespon($userpanic_id);
            foreach ($getAccount as $data) {
                $notif =  $this->M_pushnotif->sendMessageResponse($data->user_id_device);
            }
            $ret = array(
                'message' => 'Sukses',
            );
        } else {
            $ret = array(
                'message' => 'Gagal',
            );
        }
        echo json_encode($ret);
    }

    public function createPanicClose()
    {
        $panic_transc_id = $this->uri->segment(3);
        $update_dttm = $this->date->dateNow();

        $data = array(
            'update_dttm' => $update_dttm,
            'status_respon' => 'close',
        );


        $res = $this->M_Panictransaction->setPanicClose($data, $panic_transc_id);
        if ($res == true) {
            $ret = array(
                'message' => 'Sukses',
            );
        } else {
            $ret = array(
                'message' => 'Gagal',
            );
        }
        echo json_encode($ret);
    }

    public function getUserRespon()
    {
        $user_id = $this->uri->segment(3);
        $res = $this->M_Panictransaction->getUserRespon($user_id);
        $jumlah_data = count($res);
        if (count($res) > 0) {
            foreach ($res as $data) {
                $created_dttm = $this->date->panjang($data->created_dttm);
                $created_time = date("H:i", strtotime($data->created_dttm));
                $gender_cd = $data->gender_cd;
                if ($gender_cd == 'l') {
                    $gender_cd = 'Laki-laki';
                } else {
                    $gender_cd = 'Perempuan';
                }
                $image_path = $data->image_path;
                if ($image_path == '') {
                    $image_path = '/images/persons/';
                }
                $image_nm = $data->image_nm;
                if ($image_nm == '') {
                    if ($gender_cd == 'Laki-laki') {
                        $image_nm = 'male.png';
                    } else {
                        $image_nm = 'female.png';
                    }
                } else {
                    $image_nm = $image_nm;
                }
                $cellphone = $data->cellphone;
                if ($cellphone == '') {
                    $cellphone = '-';
                }

                $ret[] = array(
                    'message' => 'Sukses',
                    'panic_transc_id' => $data->panic_transc_id,
                    'userrespon_id' =>  $data->userrespon_id,
                    'latitude' =>  $data->latitude,
                    'longitude' =>  $data->longitude,
                    'created_dttm' =>  $created_dttm,
                    'created_time' =>  $created_time,
                    'person_id' =>  $data->person_id,
                    'person_nm' =>  $data->person_nm,
                    'gender_cd' =>  $gender_cd,
                    'cellphone' =>  $cellphone,
                    'image_path' =>  $image_path,
                    'image_nm' =>  $image_nm,
                    'employee_id' =>  $data->employee_id,
                    'employee_ext_id' =>  $data->employee_ext_id,
                    'pangkat_nm' =>  $data->pangkat_nm,
                    'kesatuan_nm' =>  $data->kesatuan_nm,
                    'status_respon' =>  $data->status_respon,
                    'jumlah_data' =>  $jumlah_data,
                );
            }
        } else {
            $ret[] = array(
                'message' => 'Gagal'
            );
        }
        echo json_encode($ret);
    }

    public function getUserPanic()
    {
        $user_id = $this->uri->segment(3);
        $res = $this->M_Panictransaction->getUserPanic($user_id);
        $jumlah_data = count($res);
        if (count($res) > 0) {
            foreach ($res as $data) {
                $created_dttm = $this->date->panjang($data->created_dttm);
                $created_time = date("H:i", strtotime($data->created_dttm));
                $gender_cd = $data->gender_cd;
                if ($gender_cd == 'l') {
                    $gender_cd = 'Laki-laki';
                } else {
                    $gender_cd = 'Perempuan';
                }
                $image_path = $data->image_path;
                if ($image_path == '') {
                    $image_path = '/images/persons/';
                }
                $image_nm = $data->image_nm;
                if ($image_nm == '') {
                    if ($gender_cd == 'Laki-laki') {
                        $image_nm = 'male.png';
                    } else {
                        $image_nm = 'female.png';
                    }
                } else {
                    $image_nm = $image_nm;
                }
                $cellphone = $data->cellphone;
                if ($cellphone == '') {
                    $cellphone = '-';
                }

                $ret[] = array(
                    'message' => 'Sukses',
                    'panic_transc_id' => $data->panic_transc_id,
                    'userpanic_id' =>  $data->userpanic_id,
                    'latitude' =>  $data->latitude,
                    'longitude' =>  $data->longitude,
                    'created_dttm' =>  $created_dttm,
                    'created_time' =>  $created_time,
                    'person_id' =>  $data->person_id,
                    'person_nm' =>  $data->person_nm,
                    'gender_cd' =>  $gender_cd,
                    'cellphone' =>  $cellphone,
                    'image_path' =>  $image_path,
                    'image_nm' =>  $image_nm,
                    'employee_id' =>  $data->employee_id,
                    'employee_ext_id' =>  $data->employee_ext_id,
                    'pangkat_nm' =>  $data->pangkat_nm,
                    'kesatuan_nm' =>  $data->kesatuan_nm,
                    'status_respon' =>  $data->status_respon,
                    'jumlah_data' =>  $jumlah_data,
                );
            }
        } else {
            $ret[] = array(
                'message' => 'Gagal'
            );
        }
        echo json_encode($ret);
    }
    
    public function getHospital()
    {

        $res = $this->M_Panictransaction->getHospital();
        if (count($res) > 0) {
            foreach ($res as $data) {

                $ret[] = array(
                    'message' => 'Sukses',
                    'hospital_id' => $data->hospital_id,
                    'hospital_nm' => $data->hospital_nm,
                    'telephone' => $data->telephone,
                    'longitude' => $data->longitude,
                    'latitude' => $data->latitude,
                    'addr_txt' => $data->addr_txt,
                );
            }
        } else {
            $ret[] = array(
                'message' => 'Gagal'
            );
        }
        echo json_encode($ret);
    }
    
    public function insertBukti()
	{
		$panic_transc_id = $this->uri->segment(3);
        	$created_dttm = $this->date->dateNow();
		$images['upload_path']     = '../assets/images/bukti/';
		$images['allowed_types']   = 'jpg|png|jpeg|PNG|JPG|JPEG';
		$image                  = $_FILES['file']['name'];
		$images['file_name']    = $panic_transc_id . '-' . md5($image);
		$this->load->library('upload', $images);
		$this->upload->initialize($images);
		if ($this->upload->do_upload('file')) {
			$uploadData = $this->upload->data();
			$images['image_library'] = 'gd2';
			$images['source_image'] = '../assets/images/bukti/' . $uploadData['file_name'];
			$images['create_thumb'] = FALSE;
			$images['maintain_ratio'] = FALSE;
			$images['quality'] = '50%';
			$images['new_image'] = '../assets/images/bukti/' . $uploadData['file_name'];
			$this->load->library('image_lib', $images);
			$this->image_lib->resize();

			$data = array(
				'image_nm' => $uploadData['file_name'],
				'image_path' => '/images/bukti/',
				'panic_transc_id' => $panic_transc_id,
				'created_dttm' => $created_dttm,
			);

			$uploadPoto = $this->M_Panictransaction->uploadBukti($data);
			if ($uploadPoto == TRUE) {
				$ret = array(
					'message' => 'Sukses',
					'image_nm' => $uploadData['file_name'],
					'image_path' => '/images/',
					// 'aa' => $this->upload->initialize($images)
				);
			} else {
				$ret = array('message' => 'Gagal2');
			}
		} else {
			$ret = array('message' => 'Gagal');
		}
		echo json_encode($ret);
	}

}
