<?php namespace App\Models;

use CodeIgniter\Model;

class Usersmodel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['user_nm', 'pwd0','user_group','person_id','status_cd', 'created_dttm','created_user','update_dttm','update_user','nullified_dttm','nullified_user'];


    public function checklogin($u,$p) {
        return $this->db->table($this->table)
                        ->where('user_nm',$u)
                        ->where('pwd0',$p)
                        ->where('user_group','admin')
                        ->get();
    }

    public function getbyId($id){
        return $this->db->table('persons a')
                        ->select('*')
                        ->join('users b', 'b.person_id = a.person_id','left')
                        ->where('a.person_id',$id)
                        ->get();
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