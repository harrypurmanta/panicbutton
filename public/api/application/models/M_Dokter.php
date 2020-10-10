<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Dokter extends CI_Model
{
    public function getDokter($id)
    {
        $this->db->select('a.keahlian_medic_id, b.keahlian_nm, b.keahlian_id, c.person_nm, c.person_id,c.image_nm,c.image_path,c.gender_cd, d.employee_id, d.employee_ext_id');
        $this->db->from('keahlian_medic a');
        $this->db->join('keahlian b', 'b.keahlian_id=a.keahlian_id', 'left');
        $this->db->join('persons c', 'c.person_id=a.person_id', 'left');
        $this->db->join('employee d', 'd.person_id=c.person_id', 'left');
        // $this->db->where('c.status_cd', 'normal');
        $this->db->where('a.keahlian_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getKeahlian()
    {
        $this->db->select('*');
        $this->db->from('keahlian');
        $this->db->where('status_cd', 'normal');
        $query = $this->db->get();
        return $query->result();
    }
}
