<?php namespace App\Models;

use CodeIgniter\Model;

class Employeemodel extends Model
{
    protected $table      = 'persons';
    protected $primaryKey = 'person_id';
    protected $allowedFields = ['person_id', 'person_nm','ext_id','ext_id_txt','birth_dttm','birth_place','gender_cd','addr_txt','cellphone','status_cd', 'created_dttm','created_user','update_dttm','update_user','nullified_dttm','nullified_user'];
    // protected $useTimestamps = true;
    // protected $createdField  = 'created_dttm';
    // protected $updatedField  = 'update_dttm';
    // protected $deletedField  = 'nullified_dttm';

  


    public function getBynm($person_nm){
        $res = $this->where('person_nm',$person_nm)
                                    ->findAll();
        return $res;
    }

    public function getbyext_id($ext_id){
        return $res = $this->where('ext_id',$ext_id)
                                    ->findAll();
    }

    public function getBylikenm($person_nm) {
        $db = db_connect('default');
        $builder = $db->table('persons a');
        $builder->select('*');
        $builder->join('employee b', 'b.person_id = a.person_id','left');
        $builder->like('a.person_nm',$person_nm);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getbyId($id){
        $db = db_connect('default');
        $builder = $db->table('persons a');
        $builder->select('*');
        $builder->join('employee b', 'b.person_id = a.person_id','left');
        $builder->join('pangkat c','c.pangkat_id=b.pangkat_id','left');
        $builder->join('kesatuan d','d.kesatuan_id=b.kesatuan_id','left');
        $builder->where('a.person_id',$id);
        $query = $builder->get();
        return $query->getResult();
    }

    public function simpan($data){
        $db = db_connect('default'); 
        $builder = $db->table('persons');

        $builder->insert($data);
        return $db->insertID();
    }

    public function simpanemp($data) {
    	return $this->db->table('employee')
    			 ->insert($data);
    }

    public function updateemp($id,$data) {
    	return $this->db->table('employee')
    					->set($data)
    					->update();
    }
}