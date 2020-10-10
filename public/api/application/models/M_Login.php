<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Login extends CI_Model {
	public function __construct()
	{
		parent:: __construct();
	}

	public function getLogin($username,$password)
	{
		$this->db->select('a.user_id, a.person_id,c.employee_id, a.user_group, b.ext_id, b.person_nm, b.birth_dttm, b.gender_cd, b.cellphone, b.addr_txt, c.employee_ext_id, d.jabatan_nm, e.golongan_nm, f.pangkat_nm, g.kesatuan_nm, b.image_path, b.image_nm');
		$this->db->from('users a');
		$this->db->join('persons b','b.person_id=a.person_id','left');
		$this->db->join('employee c','c.person_id=b.person_id','left');
		$this->db->join('jabatan d','d.jabatan_id=c.jabatan_id','left');
		$this->db->join('golongan e','e.golongan_id=c.gol_id','left');
		$this->db->join('pangkat f','f.pangkat_id=c.pangkat_id','left');
		$this->db->join('kesatuan g','g.kesatuan_id=c.kesatuan_id','left');
		$this->db->where('c.employee_ext_id',$username);
		$this->db->where('a.pwd0',$password);
		$this->db->where('a.status_cd', 'normal');
		$query = $this->db->get();
		return $query->result();
	}

	public function sessionLogin($data) {
		$insert = $this->db->insert('session_login_mobile', $data);
	    return $insert;
	}

	public function sessionLogout($data,$user_id, $user_id_device) {
		$this->db->where('user_id',$user_id);
		$this->db->where('user_id_device',$user_id_device);
		$this->db->order_by('session_login','DESC');
	     $update = $this->db->update('session_login_mobile', $data);
	     return $update;
	}

	public function updateUser($data,$person_id) {
		$this->db->where('person_id',$person_id);
	     $update = $this->db->update('persons', $data);
	     return $update;
	}

	public function updatePassword($data,$user_id) {
		$this->db->where('user_id',$user_id);
	     $update = $this->db->update('users', $data);
	     return $update;
	}

	public function cekPass($user_id, $pass) {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_id',$user_id);
		$this->db->where('pwd0',$pass);
		$query = $this->db->get();
		return $query->result();
	}

	public function updatePoto($person_id,$data) {
		$this->db->where('person_id',$person_id);
	     $update = $this->db->update('persons', $data);
	     return $update;
	}


}