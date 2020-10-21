<?php namespace App\Models;

use CodeIgniter\Model;

class Panicmodel extends Model
{
    protected $table      = 'panic_transc';
    protected $primaryKey = 'panic_transc_id ';
    protected $allowedFields = ['userpanic_id','userrespon_id', 'status_cd', 'created_dttm','created_user','update_dttm','update_user','nullified_dttm','nullified_user'];
    protected $kategorimodel;

    public function getbynormal() {
    	return $this->db->table('panic_transc a')
    			->select('a.panic_transc_id,d.person_nm as userpanic,d.cellphone as phonepanic,d.addr_txt as addrpanic,f.employee_ext_id as nrppanic,h.pangkat_nm as pangkatpanic, k.kesatuan_nm as kesatuanpanic,a.longitude,a.latitude,a.created_dttm')
    			->join('users b','b.user_id=a.userpanic_id','left')
    			->join('users c','c.user_id=a.userrespon_id','left')
    			->join('persons d','d.person_id=b.person_id','left')
    			->join('persons e','e.person_id=c.person_id','left')
    			->join('employee f','f.person_id=d.person_id','left')
    			->join('employee g','g.person_id=e.person_id','left')
    			->join('pangkat h','h.pangkat_id=f.pangkat_id','left')
    			->join('pangkat i','i.pangkat_id=g.pangkat_id','left')
    			->join('kesatuan j','j.kesatuan_id=f.kesatuan_id','left')
    			->join('kesatuan k','k.kesatuan_id=g.kesatuan_id','left')
    			->where('a.status_cd','normal')
    			->get();
    }

    public function getbyGolnm($panic_nm) {
    	return $this->db->table('panic_transc')
    			->select('*')
    			->where('status_cd','normal')
    			->where('panic_nm', $panic_nm)
    			->get();
    }

    public function getbyid($id) {
        return $this->db->table('panic_transc a')
                ->select('a.panic_transc_id,d.person_nm as userpanic,d.cellphone as phonepanic,d.addr_txt as addrpanic,d.gender_cd,d.birth_place,d.birth_dttm,e.person_nm as userrespon,e.cellphone as phonerespon,e.addr_txt as addrrespon,e.gender_cd as gender_respon,e.birth_place as birthplace_respon,e.birth_dttm as birth_dttm_respon,f.employee_ext_id as nrppanic,h.pangkat_nm as pangkatpanic, k.kesatuan_nm as kesatuanpanic,a.longitude,a.latitude,a.created_dttm, d.image_nm')
                ->join('users b','b.user_id=a.userpanic_id','left')
                ->join('users c','c.user_id=a.userrespon_id','left')
                ->join('persons d','d.person_id=b.person_id','left')
                ->join('persons e','e.person_id=c.person_id','left')
                ->join('employee f','f.person_id=d.person_id','left')
                ->join('employee g','g.person_id=e.person_id','left')
                ->join('pangkat h','h.pangkat_id=f.pangkat_id','left')
                ->join('pangkat i','i.pangkat_id=g.pangkat_id','left')
                ->join('kesatuan j','j.kesatuan_id=f.kesatuan_id','left')
                ->join('kesatuan k','k.kesatuan_id=g.kesatuan_id','left')
                ->where('a.status_cd','normal')
                ->where('panic_transc_id',$id)
                ->get();
    }

    public function countpanic() {
        return $this->db->table('panic_transc')
                        ->select('count(panic_transc_id) as jumlahpanic')
                        ->where('status_cd','normal')
                        ->get();
    }

    public function countemp() {
        return $this->db->table('users')
                        ->select('count(user_id) as jumlahpasien')
                        ->where('user_group','employee')
                        ->where('status_cd','normal')
                        ->get();
    }

    public function countmedis() {
        return $this->db->table('users')
                        ->select('count(user_id) as jumlahmedis')
                        ->where('user_group','medic')
                        ->where('status_cd','normal')
                        ->get();
    }

    public function countrs() {
        return $this->db->table('hospital')
                        ->select('count(hospital_id) as jumlahrs')
                        ->where('status_cd','normal')
                        ->get();
    }
}