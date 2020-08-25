<?php namespace App\Models;

use CodeIgniter\Model;

class Usersmodel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['user_nm', 'pwd0','user_group','person_id','status_cd', 'created_dttm','created_user','update_dttm','update_user','nullified_dttm','nullified_user'];


    public function checklogin($u,$p) {
        $Usersmodel = new Usersmodel();
    	$users = $Usersmodel->where('user_nm',$u)
                            ->where('pwd0',$p)
                            ->findAll();
        return $users;
    }

    public function getbyId($id){
        $db = db_connect('default');
        $builder = $db->table('persons a');
        $builder->select('*');
        $builder->join('users b', 'b.person_id = a.person_id','left');
        $builder->where('a.person_id',$id);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getbyUsernm($user_nm){
        $db = db_connect('default');
        $builder = $db->table('users');
        $builder->select('*');
        $builder->where('user_nm',$user_nm);
        $query = $builder->get();
        return $query->getResult(); 
    }

    public function simpan($data) {
        return $this->db->table('users')
                    ->insert($data);
    }
}