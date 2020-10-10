<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Artikel extends CI_Model
{
    public function getData()
    {
        $this->db->select('a.artikel_nm, a.artikel_id, a.artikel_img, a.description, a.created_dttm, b.keahlian_nm');
        $this->db->from('artikel a');
		$this->db->join('keahlian b','b.keahlian_id=a.keahlian_id','left');
        $this->db->where('a.status_cd', 'normal');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function uploadBukti($data) {
	$insert = $this->db->insert('image', $data);
	return $insert;
	}
}
