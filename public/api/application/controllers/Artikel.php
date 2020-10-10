<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Artikel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Artikel');
        $this->load->library('dateFunction/date');
    }

    public function getData()
    {

        $res = $this->M_Artikel->getData();
        if (count($res) > 0) {
            foreach ($res as $data) {
                $descTemp = strlen($data->description);
                if($descTemp > 45){
                    $description = substr($data->description,0,44). "..";
                } else {
                    $description = $data->description;
                }
                $ret[] = array(
                    'message' => 'Sukses',
                    'artikel_id' => $data->artikel_id,
                    'artikel_nm' => $data->artikel_nm,
                    'category_id' => $data->artikel_id,
                    'descriptionShort' => $description,
                    'description' => $data->description,
                    'artikel_img' => $data->artikel_img,
                    'kategory' => 'Dokter '.ucwords(strtolower($data->keahlian_nm)),
                    'created_dttm'=> $this->date->dateSlash($data->created_dttm),
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
