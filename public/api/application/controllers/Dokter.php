<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokter extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Dokter');
        $this->load->library('dateFunction/date');
    }

    public function getKeahlian()
    {
        $res = $this->M_Dokter->getKeahlian();
        if (count($res) > 0) {
            foreach ($res as $data) {
                $ret[] = array(
                    'message' => 'Sukses',
                    'keahlian_id' => $data->keahlian_id,
                    'keahlian_nm' => ucwords(strtolower($data->keahlian_nm)),
                );
            }
        } else {
            $ret[] = array(
                'message' => 'Empty'
            );
        }
        echo json_encode($ret);
    }

    public function getDokter()
    {
        $keahlian_id = $this->uri->segment(3);
        $res = $this->M_Dokter->getDokter($keahlian_id);
        if (count($res) > 0) {
            foreach ($res as $data) {
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
                    'keahlian_medic_id' => $data->keahlian_medic_id,
                    'keahlian_nm' => 'Dokter '. ucwords(strtolower($data->keahlian_nm)),
                    'keahlian_id' => $data->keahlian_id,
                    'person_nm' => $data->person_nm,
                    'person_id' => $data->person_id,
                    'employee_id' => $data->employee_id,
                    'employee_ext_id' => $data->employee_ext_id,
                    'image_path' =>  $image_path,
                    'image_nm' =>  $image_nm,
                );
            }
        } else {
            $ret[] = array(
                'message' => 'Empty'
            );
        }
        echo json_encode($ret);
    }
}
