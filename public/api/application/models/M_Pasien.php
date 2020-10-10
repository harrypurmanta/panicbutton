<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Pasien extends CI_Model
{
    public function getPasien()
    {
        $this->db->select('a.user_id, a.person_id,c.employee_id, a.user_group, b.ext_id, b.person_nm, b.birth_dttm, b.gender_cd, b.cellphone, b.addr_txt, c.employee_ext_id, d.jabatan_nm, e.golongan_nm, f.pangkat_nm, g.kesatuan_nm, b.image_path, b.image_nm');
		$this->db->from('users a');
		$this->db->join('persons b','b.person_id=a.person_id','left');
		$this->db->join('employee c','c.person_id=b.person_id','left');
		$this->db->join('jabatan d','d.jabatan_id=c.jabatan_id','left');
		$this->db->join('golongan e','e.golongan_id=c.gol_id','left');
		$this->db->join('pangkat f','f.pangkat_id=c.pangkat_id','left');
		$this->db->join('kesatuan g','g.kesatuan_id=c.kesatuan_id','left');
		$this->db->where('a.user_group', 'employee');
		$this->db->where('a.status_cd', 'normal');
		$query = $this->db->get();
		return $query->result();
    }

}
