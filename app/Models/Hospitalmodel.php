<?php namespace App\Models;

use CodeIgniter\Model;

class Hospitalmodel extends Model
{
    protected $table      = 'hospital';
    protected $primaryKey = 'hospital_id ';
    protected $allowedFields = ['hospital_nm','telephone','longitude','latitude','addr_txt','location_id','status_cd', 'created_dttm','created_user','update_dttm','update_user','nullified_dttm','nullified_user'];
    protected $kategorimodel;

    public function getbynormal() {
    	return $this->db->table('hospital')
    			->select('*')
    			->where('status_cd','normal')
    			->get();
    }

    public function getbyGolnm($hospital_nm) {
    	return $this->db->table('hospital')
    			->select('*')
    			->where('status_cd','normal')
    			->where('hospital_nm', $hospital_nm)
    			->get();
    }
}