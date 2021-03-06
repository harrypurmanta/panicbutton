<?php namespace App\Models;

use CodeIgniter\Model;

class Employeemodel extends Model
{
    protected $table      = 'persons';
    protected $primaryKey = 'person_id';
    protected $allowedFields = ['person_id', 'person_nm','ext_id','ext_id_txt','birth_dttm','birth_place','gender_cd','addr_txt','cellphone','image_path','image_nm','status_cd', 'created_dttm','created_user','update_dttm','update_user','nullified_dttm','nullified_user'];
    // protected $useTimestamps = true;
    // protected $createdField  = 'created_dttm';
    // protected $updatedField  = 'update_dttm';
    // protected $deletedField  = 'nullified_dttm';

  
    public function getbynormal() {
        return $this->db->table($this->table)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getbyemployee() {
        return $this->db->table('persons a')
                        ->join('employee b','b.person_id=a.person_id','left')
                        ->join('users c','c.person_id=a.person_id','left')
                        ->join('pangkat d','d.pangkat_id=b.pangkat_id','left')
                        ->join('jabatan e','e.jabatan_id=b.jabatan_id','left')
                        ->join('kesatuan f','f.kesatuan_id=b.kesatuan_id','left')
                        ->where('a.status_cd','normal')
                        ->where('c.user_group','employee')
                        ->get();
    }


    public function getBynm($person_nm){
        return $this->db->table('persons')
                        ->where('person_nm',$person_nm)
                        ->get();
    }

    public function getbyext_id($ext_id){
        return $this->db->table('persons')
                        ->where('ext_id',$ext_id)
                        ->get();
    }

    public function getBylikenm($person_nm) {
        return $this->db->table('persons a')
                         ->select('*')
                         ->join('employee b', 'b.person_id = a.person_id','left')
                         ->like('a.person_nm',$person_nm)
                         ->get();
    }

    public function getbyId($id){
        return $this->db->table('persons a')
                         ->select('*')
                         ->join('employee b', 'b.person_id = a.person_id','left')
                         ->join('pangkat c','c.pangkat_id=b.pangkat_id','left')
                         ->join('kesatuan d','d.kesatuan_id=b.kesatuan_id','left')
                         ->where('a.person_id',$id)
                         ->get();
    }

    public function getmedis() {
        return $this->db->table('persons a')
                        ->join('employee b','b.person_id=a.person_id','left')
                        ->join('users c','c.person_id=a.person_id','left')
                        ->join('pangkat d','d.pangkat_id=b.pangkat_id','left')
                        ->join('jabatan e','e.jabatan_id=b.jabatan_id','left')
                        ->join('kesatuan f','f.kesatuan_id=b.kesatuan_id','left')
                        ->where('a.status_cd','normal')
                        ->where('c.user_group','medic')
                        ->orderby('a.person_nm','ASC')
                        ->get();
    }

    public function getmedisbyid($id) {
        return $this->db->table('persons a')
                        ->join('employee b','b.person_id=a.person_id','left')
                        ->join('users c','c.person_id=a.person_id','left')
                        ->join('pangkat d','d.pangkat_id=b.pangkat_id','left')
                        ->join('jabatan e','e.jabatan_id=b.jabatan_id','left')
                        ->join('kesatuan f','f.kesatuan_id=b.kesatuan_id','left')
                        ->where('a.status_cd','normal')
                        ->where('c.user_group','medic')
                        ->where('a.person_id',$id)
                        ->get();
    }

    public function simpan($data){
        $this->db->table('persons')
                  ->insert($data);
        return $this->db->insertID();
    }

    public function simpanemp($data) {
    	return $this->db->table('employee')
    			 ->insert($data);
    }

    public function updateemp($id,$data) {
    	return $this->db->table('employee')
    					->set($data)
                        ->where('person_id',$id)
    					->update();
    }
}