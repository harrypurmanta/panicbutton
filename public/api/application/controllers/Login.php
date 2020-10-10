<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Login');
		$this->load->library('dateFunction/date');
	}

	public function getLogin()
	{
		$username = $this->uri->segment(3);
		$password = md5($this->uri->segment(4));
		$res = $this->M_Login->getLogin($username, $password);
		if ($res == true) {
			foreach ($res as $data) {
				$user_id = $data->user_id;
				$person_id = $data->person_id;
				$employee_id = $data->employee_id;
				$user_group = $data->user_group;
				$ext_id = $data->ext_id;
				$person_nm = $data->person_nm;
				$birth_dttm = $data->birth_dttm;
				if ($birth_dttm == '0000-00-00 00:00:00') {
					$birth_dttm = '0000-00-00';
				} else {
					$birth_dttm = $this->date->panjang($birth_dttm);
				}
				$gender_cd = $data->gender_cd;
				if ($gender_cd == 'l') {
					$gender_cd = 'Laki-laki';
				} else {
					$gender_cd = 'Perempuan';
				}
				$cellphone = $data->cellphone;
				if ($cellphone == '') {
					$cellphone = '-';
				} else {
					$cellphone = $cellphone;
				}
				$addr_txt = $data->addr_txt;
				if ($addr_txt == '') {
					$addr_txt = '-';
				} else {
					$addr_txt = $addr_txt;
				}
				$employee_ext_id = $data->employee_ext_id;
				if ($employee_ext_id == '') {
					$employee_ext_id = '-';
				} else {
					$employee_ext_id = $employee_ext_id;
				}
				$jabatan_nm = $data->jabatan_nm;
				if ($jabatan_nm == '') {
					$jabatan_nm = '-';
				} else {
					$jabatan_nm = $jabatan_nm;
				}
				$golongan_nm = $data->golongan_nm;
				if ($golongan_nm == '') {
					$golongan_nm = '-';
				} else {
					$golongan_nm = $golongan_nm;
				}
				$pangkat_nm = $data->pangkat_nm;
				if ($pangkat_nm == '') {
					$pangkat_nm = '-';
				} else {
					$pangkat_nm = $pangkat_nm;
				}
				$kesatuan_nm = $data->kesatuan_nm;
				if ($kesatuan_nm == '') {
					$kesatuan_nm = '-';
				} else {
					$kesatuan_nm = $kesatuan_nm;
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

				$ret = array(
					'message' => 'Sukses',
					'user_id' => $user_id,
					'person_id' => $person_id,
					'employee_id' => $employee_id,
					'user_group' => $user_group,
					'ext_id' => $ext_id,
					'person_nm' => $person_nm,
					'birth_dttm' => $birth_dttm,
					'gender_cd' => $gender_cd,
					'cellphone' => $cellphone,
					'addr_txt' => $addr_txt,
					'employee_ext_id' => $employee_ext_id,
					'jabatan_nm' => $jabatan_nm,
					'golongan_nm' => $golongan_nm,
					'pangkat_nm' => $pangkat_nm,
					'kesatuan_nm' => $kesatuan_nm,
					'image_path' => $image_path,
					'image_nm' => $image_nm
				);
			}
		} else {
			$ret = array(
				'message' => 'Gagal',
			);
		}
		echo json_encode($ret);
	}

	public function getUser()
	{
		$idUser = $this->uri->segment(3);
		$res = $this->M_Login->getUser($idUser);

		if ($res == true) {
			foreach ($res as $data) {

				$jk = $data->jenisKelamin;
				$foto = $data->foto;
				if ($foto == '') {
					if ($jk == 'Laki-Laki') {
						$avatar = 'assets/images/users/avatar.png';
					} else {
						$avatar = 'assets/images/users/avatar3.png';
					}
				} else {
					$avatar = $foto;
				}

				$alamat = $data->alamat;
				if ($alamat == '') {
					$address = '-';
				} else {
					$address = $alamat;
				}

				$ret[] = array(
					'message' 	=> 'Sukses',
					'idJabatan' => $data->idJabatan,
					'nmJabatan' => $data->nmJabatan,
					'nip' => $data->nip,
					'nama' => $data->nama,
					'jenisKelamin' => $jk,
					'email' => $data->email,
					'telepon' => $data->telepon,
					'alamat' => $address,
					'foto' => $avatar,
				);
			}
		} else {
			$ret[] = array(
				'message' => 'Gagal',
			);
		}

		echo json_encode($ret);
	}

	public function updateUser()
	{
		$person_id = urldecode($this->uri->segment(3));
		$person_nm = urldecode($this->uri->segment(4));
		$cellphone = urldecode($this->uri->segment(5));
		$addr_txt = urldecode($this->uri->segment(6));

		$dataUser = array(
			'person_nm' => $person_nm,
			'cellphone' => $cellphone,
			'addr_txt' => $addr_txt,
		);

		$updateUser = $this->M_Login->updateUser($dataUser, $person_id);
		if ($updateUser == true) {
			echo json_encode('Sukses');
		} else {
			echo json_encode('eroor');
		}
	}

	public function updatePass()
	{
		$user_id = urldecode($this->uri->segment(3));
		$oldPass = md5($this->uri->segment(4));
		$newPass = md5($this->uri->segment(5));

		$cekPass = $this->M_Login->cekPass($user_id, $oldPass);
		if (count($cekPass) > 0) {
			$dataUser = array(
				'pwd0' => $newPass,
			);

			$updateUser = $this->M_Login->updatePassword($dataUser, $user_id);
			if ($updateUser == true) {
				echo json_encode('Sukses');
			} else {
				echo json_encode('Gagal');
			}
		} else {
			echo json_encode('Gagal2');
		}
	}

	public function sessionLogin()
	{
		$id_user = urldecode($this->uri->segment(3));
		$user_id_device = urldecode($this->uri->segment(4));
		$session_time = date('Y-m-d H:i:s');
		$dataSession = array(
			'user_id' => $id_user,
			'user_id_device' => $user_id_device,
			'session_login' => $session_time,
			'session_status' => 'login',
		);

		$insert = $this->M_Login->sessionLogin($dataSession);
		if ($insert == true) {
			echo json_encode('Sukses');
		} else {
			echo json_encode('eroor');
		}
	}

	public function sessionLogout()
	{
		$user_id = urldecode($this->uri->segment(3));
		$user_id_device = urldecode($this->uri->segment(4));
		$session_time = date('Y-m-d H:i:s');
		$dataSession = array(
			'session_logout' => $session_time,
			'session_status' => 'logout',
		);

		$insert = $this->M_Login->sessionLogout($dataSession, $user_id, $user_id_device);
		if ($insert == true) {
			echo json_encode('Sukses');
		} else {
			echo json_encode('eroor');
		}
	}

	public function insertImage()
	{
		$person_id = $this->uri->segment(3);
		$images['upload_path']     = '../assets/images/persons/';
		$images['allowed_types']   = 'jpg|png|jpeg|PNG|JPG|JPEG';
		$image                  = $_FILES['file']['name'];
		$images['file_name']    = $person_id . '-' . md5($image);
		$this->load->library('upload', $images);
		$this->upload->initialize($images);
		if ($this->upload->do_upload('file')) {
			$uploadData = $this->upload->data();
			$images['image_library'] = 'gd2';
			$images['source_image'] = '../assets/images/persons/' . $uploadData['file_name'];
			$images['create_thumb'] = FALSE;
			$images['maintain_ratio'] = FALSE;
			$images['quality'] = '50%';
			$images['new_image'] = '../assets/images/persons/' . $uploadData['file_name'];
			$this->load->library('image_lib', $images);
			$this->image_lib->resize();

			$data = array(
				'image_nm' => $uploadData['file_name'],
				'image_path' => '/images/persons/',
			);

			$updatePoto = $this->M_Login->updatePoto($person_id, $data);
			if ($updatePoto == TRUE) {
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

	public function updateApk()
	{
		$ret = array(
			'versi' => '2.0',
		);

		echo json_encode($ret);
	}
}
