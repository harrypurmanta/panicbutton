<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pasien extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Pasien');
        $this->load->library('dateFunction/date');
    }

    public function getPasien()
    {
        $res = $this->M_Pasien->getPasien();
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

                $ret[] = array(
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
            $ret[] = array(
                'message' => 'Gagal',
            );
        }
        echo json_encode($ret);
    }
}
