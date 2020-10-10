<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_RiwayatMedis extends CI_Model
{
    public function getData($id)
    {
        $this->db->select('a.hospital_admission_id, b.person_nm, a.admission_dttm, c.keahlian_nm, a.admission_diag');
        $this->db->from('his_patient_admission a');
		$this->db->join('persons b','b.person_id=a.person_id','left');
		$this->db->join('keahlian c','c.keahlian_id=a.keahlian_id','left');
        $this->db->where('a.person_id', $id);
        $this->db->where('a.status_cd', 'normal');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function uploadBukti($data) {
	$insert = $this->db->insert('image', $data);
	return $insert;
	}
}
