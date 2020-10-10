<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RiwayatMedis extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_RiwayatMedis');
        $this->load->library('dateFunction/date');
    }

    public function getData()
    {
        $person_id = $this->uri->segment(3);
        $res = $this->M_RiwayatMedis->getData($person_id);
        if (count($res) > 0) {
            foreach ($res as $data) {
                $keahlian = strtolower($data->keahlian_nm);
                
                $admission_diag = $data->admission_diag;
                if($admission_diag == ''){
                    $admission_diag = '-';
                }
                $ret[] = array(
                    'message' => 'Sukses',
                    'hospital_admission_id' => $data->hospital_admission_id,
                    'person_nm' => $data->person_nm,
                    'admission_dttm' => $this->date->panjang($data->admission_dttm),
                    'keahlian_nm' => ucwords($keahlian),
                    'admission_diag' => ucwords($admission_diag)
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
