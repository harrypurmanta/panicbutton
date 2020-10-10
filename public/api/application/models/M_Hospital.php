<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Hospital extends CI_Model
{
    public function getHospital($id)
    {
        $this->db->select('a.hospital_nm, a.telephone, a.longitude, a.latitude, a.addr_txt, b.location_nm');
        $this->db->from('hospital a');
        $this->db->join('location b', 'b.location_id=a.location_id', 'left');
        $this->db->where('a.status_cd', 'normal');
        $this->db->where('a.location_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getDaerah()
    {
        $this->db->select('*');
        $this->db->from('location');
        $this->db->where('status_cd', 'normal');
        $query = $this->db->get();
        return $query->result();
    }

    public function uploadBukti($data)
    {
        $insert = $this->db->insert('image', $data);
        return $insert;
    }
}
