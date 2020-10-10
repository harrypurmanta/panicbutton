<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_panictransaction extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPanicWaiting($status_respon, $user_id)
    {
        $this->db->select('a.panic_transc_id, a.userpanic_id, a.latitude, a.longitude,a.status_respon, a.created_dttm, c.person_id, c.person_nm,c.gender_cd, c.cellphone, c.image_path, c.image_nm, d.employee_id, d.employee_ext_id, e.pangkat_nm, f.kesatuan_nm');
        $this->db->from('panic_transc a');
        $this->db->join('users b', 'a.userpanic_id=b.user_id', 'left');
        $this->db->join('persons c', 'c.person_id=b.person_id', 'left');
        $this->db->join('employee d', 'c.person_id=d.person_id', 'left');
        $this->db->join('pangkat e', 'e.pangkat_id=d.pangkat_id', 'left');
        $this->db->join('kesatuan f', 'f.kesatuan_id=d.kesatuan_id', 'left');
        $this->db->where('a.status_cd', 'normal');
        $this->db->where('a.status_respon', $status_respon);
        $this->db->where('a.userpanic_id !=', $user_id);
        $this->db->order_by('a.created_dttm', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getPanicRiwayat($user_id)
    {
        $status_respon = array('confirm', 'close');
        $this->db->select('a.panic_transc_id, a.userpanic_id, a.userrespon_id, a.latitude, a.longitude,a.status_respon, a.created_dttm, c.person_id, c.person_nm,c.gender_cd, c.cellphone, c.image_path, c.image_nm, d.employee_id, d.employee_ext_id, e.pangkat_nm, f.kesatuan_nm, h.person_nm as person_nm_respon,h.image_nm as image_nm_respon, h.image_path as image_path_respon,h.gender_cd as gender_cd_respon,h.cellphone as cellphone_respon, i.employee_ext_id as employee_ext_id_respon, j.pangkat_nm as pangkat_nm_respon, k.kesatuan_nm as kesatuan_nm_respon');
        $this->db->from('panic_transc a');
        $this->db->join('users b', 'a.userpanic_id=b.user_id', 'left');
        $this->db->join('persons c', 'c.person_id=b.person_id', 'left');
        $this->db->join('employee d', 'c.person_id=d.person_id', 'left');
        $this->db->join('pangkat e', 'e.pangkat_id=d.pangkat_id', 'left');
        $this->db->join('kesatuan f', 'f.kesatuan_id=d.kesatuan_id', 'left');
        $this->db->join('users g', 'a.userrespon_id=g.user_id', 'left');
        $this->db->join('persons h', 'g.person_id=h.person_id', 'left');
        $this->db->join('employee i', 'h.person_id=i.person_id', 'left');
        $this->db->join('pangkat j', 'j.pangkat_id=i.pangkat_id', 'left');
        $this->db->join('kesatuan k', 'k.kesatuan_id=i.kesatuan_id', 'left');
        $this->db->where('a.status_cd', 'normal');
        $this->db->where_in('a.status_respon', $status_respon);
        $this->db->where('a.userpanic_id =', $user_id);
        $this->db->order_by('a.created_dttm', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getResponRiwayat($user_id)
    {
        $status_respon = array('confirm', 'close');
        $this->db->select('a.panic_transc_id, a.userpanic_id, a.userrespon_id, a.latitude, a.longitude,a.status_respon, a.created_dttm, c.person_id, c.person_nm,c.gender_cd, c.cellphone, c.image_path, c.image_nm, d.employee_id, d.employee_ext_id, e.pangkat_nm, f.kesatuan_nm, h.person_nm as person_nm_respon,h.image_nm as image_nm_respon, h.image_path as image_path_respon,h.gender_cd as gender_cd_respon,h.cellphone as cellphone_respon, i.employee_ext_id as employee_ext_id_respon, j.pangkat_nm as pangkat_nm_respon, k.kesatuan_nm as kesatuan_nm_respon');
        $this->db->from('panic_transc a');
        $this->db->join('users b', 'a.userpanic_id=b.user_id', 'left');
        $this->db->join('persons c', 'c.person_id=b.person_id', 'left');
        $this->db->join('employee d', 'c.person_id=d.person_id', 'left');
        $this->db->join('pangkat e', 'e.pangkat_id=d.pangkat_id', 'left');
        $this->db->join('kesatuan f', 'f.kesatuan_id=d.kesatuan_id', 'left');
        $this->db->join('users g', 'a.userrespon_id=g.user_id', 'left');
        $this->db->join('persons h', 'g.person_id=h.person_id', 'left');
        $this->db->join('employee i', 'h.person_id=i.person_id', 'left');
        $this->db->join('pangkat j', 'j.pangkat_id=i.pangkat_id', 'left');
        $this->db->join('kesatuan k', 'k.kesatuan_id=i.kesatuan_id', 'left');
        $this->db->where('a.status_cd', 'normal');
        $this->db->where_in('a.status_respon', $status_respon);
        $this->db->where('a.userrespon_id =', $user_id);
        $this->db->order_by('a.created_dttm', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getPanicRiwayatId($id)
    {
        $status_respon = array('confirm', 'selesai');
        $this->db->select('a.panic_transc_id, a.userpanic_id, a.userrespon_id, a.latitude, a.longitude,a.status_respon, a.created_dttm, c.person_id, c.person_nm,c.gender_cd, c.cellphone, c.image_path, c.image_nm, d.employee_id, d.employee_ext_id, e.pangkat_nm, f.kesatuan_nm, h.person_nm as person_nm_respon,h.image_nm as image_nm_respon, h.image_path as image_path_respon,h.gender_cd as gender_cd_respon,h.cellphone as cellphone_respon, i.employee_ext_id as employee_ext_id_respon, j.pangkat_nm as pangkat_nm_respon, k.kesatuan_nm as kesatuan_nm_respon');
        $this->db->from('panic_transc a');
        $this->db->join('users b', 'a.userpanic_id=b.user_id', 'left');
        $this->db->join('persons c', 'c.person_id=b.person_id', 'left');
        $this->db->join('employee d', 'c.person_id=d.person_id', 'left');
        $this->db->join('pangkat e', 'e.pangkat_id=d.pangkat_id', 'left');
        $this->db->join('kesatuan f', 'f.kesatuan_id=d.kesatuan_id', 'left');
        $this->db->join('users g', 'a.userrespon_id=g.user_id', 'left');
        $this->db->join('persons h', 'g.person_id=h.person_id', 'left');
        $this->db->join('employee i', 'h.person_id=i.person_id', 'left');
        $this->db->join('pangkat j', 'j.pangkat_id=i.pangkat_id', 'left');
        $this->db->join('kesatuan k', 'k.kesatuan_id=i.kesatuan_id', 'left');
        $this->db->where('a.status_cd', 'normal');
        $this->db->where('a.panic_transc_id', $id);
        $this->db->order_by('a.created_dttm', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getUserRespon($user_id)
    {
        $this->db->select('a.panic_transc_id, a.userrespon_id, a.latitude, a.longitude,a.status_respon, a.created_dttm, c.person_id, c.person_nm,c.gender_cd, c.cellphone, c.image_path, c.image_nm, d.employee_id, d.employee_ext_id, e.pangkat_nm, f.kesatuan_nm');
        $this->db->from('panic_transc a');
        $this->db->join('users b', 'a.userrespon_id=b.user_id', 'left');
        $this->db->join('persons c', 'c.person_id=b.person_id', 'left');
        $this->db->join('employee d', 'c.person_id=d.person_id', 'left');
        $this->db->join('pangkat e', 'e.pangkat_id=d.pangkat_id', 'left');
        $this->db->join('kesatuan f', 'f.kesatuan_id=d.kesatuan_id', 'left');
        $this->db->where('a.status_cd', 'normal');
        $this->db->where('a.status_respon', 'confirm');
        $this->db->where('a.userpanic_id =', $user_id);
        $this->db->order_by('a.created_dttm', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getUserPanic($user_id)
    {
        $this->db->select('a.panic_transc_id, a.userpanic_id, a.latitude, a.longitude,a.status_respon, a.created_dttm, c.person_id, c.person_nm,c.gender_cd, c.cellphone, c.image_path, c.image_nm, d.employee_id, d.employee_ext_id, e.pangkat_nm, f.kesatuan_nm');
        $this->db->from('panic_transc a');
        $this->db->join('users b', 'a.userpanic_id=b.user_id', 'left');
        $this->db->join('persons c', 'c.person_id=b.person_id', 'left');
        $this->db->join('employee d', 'c.person_id=d.person_id', 'left');
        $this->db->join('pangkat e', 'e.pangkat_id=d.pangkat_id', 'left');
        $this->db->join('kesatuan f', 'f.kesatuan_id=d.kesatuan_id', 'left');
        $this->db->where('a.status_cd', 'normal');
        $this->db->where('a.status_respon', 'confirm');
        $this->db->where('a.userrespon_id =', $user_id);
        $this->db->order_by('a.created_dttm', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getPanicId($id)
    {
        $this->db->select('a.panic_transc_id, a.userrespon_id, a.userpanic_id, a.latitude, a.longitude,a.status_respon, a.created_dttm, c.person_id, c.person_nm,c.gender_cd, c.cellphone, c.image_path, c.image_nm, d.employee_id, d.employee_ext_id, e.pangkat_nm, f.kesatuan_nm');
        $this->db->from('panic_transc a');
        $this->db->join('users b', 'a.userpanic_id=b.user_id', 'left');
        $this->db->join('persons c', 'c.person_id=b.person_id', 'left');
        $this->db->join('employee d', 'c.person_id=d.person_id', 'left');
        $this->db->join('pangkat e', 'e.pangkat_id=d.pangkat_id', 'left');
        $this->db->join('kesatuan f', 'f.kesatuan_id=d.kesatuan_id', 'left');
        $this->db->where('a.panic_transc_id', $id);
        $this->db->where('a.status_cd', 'normal');
        $query = $this->db->get();
        return $query->result();
    }

    public function setPanic($data)
    {
        $insert = $this->db->insert('panic_transc', $data);
        $response_id = $this->db->insert_id();
        $result = array(
            'insertId' => $response_id,
            'response' => $insert
        );
        return $result;
    }

    public function setPanicResponse($data, $id)
    {
        $cek = $this->getPanicId($id);
        $userrespon = $cek{
            0}->userrespon_id;
        $status_respon = $cek{
            0}->status_respon;
        if ($userrespon == '0' && $status_respon == 'waiting') {
            $this->db->where('panic_transc_id', $id);
            $this->db->where('userrespon_id =', 0);
            $update = $this->db->update('panic_transc', $data);
            return $update;
        }
    }

    public function setPanicClose($data, $id)
    {
        $this->db->where('panic_transc_id', $id);
        $update = $this->db->update('panic_transc', $data);
        return $update;
    }
    
    public function getHospital()
    {
        $this->db->select('*');
        $this->db->from('hospital');
        $this->db->where('status_cd', 'normal');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function uploadBukti($data) {
	$insert = $this->db->insert('image', $data);
	return $insert;
	}
}
