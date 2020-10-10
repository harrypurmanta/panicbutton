<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hospital extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Hospital');
        $this->load->library('dateFunction/date');
    }

    public function getDaerah()
    {
        $res = $this->M_Hospital->getDaerah();
        if (count($res) > 0) {
            foreach ($res as $data) {
                $ret[] = array(
                    'message' => 'Sukses',
                    'location_id' => $data->location_id,
                    'location_nm' => $data->location_nm,
                );
            }
        } else {
            $ret[] = array(
                'message' => 'Empty'
            );
        }
        echo json_encode($ret);
    }

    public function getHospital()
    {
        $location_id = $this->uri->segment(3);
        $res = $this->M_Hospital->getHospital($location_id);
        if (count($res) > 0) {
            foreach ($res as $data) {
                $alamat = $data->addr_txt;
                if($alamat == ''){
                    $alamat = '-';
                }
                $ret[] = array(
                    'message' => 'Sukses',
                    'hospital_nm' => ucwords(strtolower($data->hospital_nm)),
                    'telephone' => $data->telephone,
                    'longitude' =>  $data->longitude,
                    'latitude' =>  $data->latitude,
                    'addr_txt' => ucwords(strtolower($alamat)),
                    'location_nm' => $data->location_nm,
                    'alamat' => ucwords(strtolower($alamat)).', '.$data->location_nm
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
