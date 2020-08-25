<?php namespace App\Models;

use CodeIgniter\Model;

class locationmodel extends Model
{
    protected $table      = 'location';
    protected $primaryKey = 'location_id ';
    protected $allowedFields = ['location_nm', 'status_cd', 'created_dttm','created_user','update_dttm','update_user','nullified_dttm','nullified_user'];
    protected $kategorimodel;

    public function getbynormal() {
    	return $this->db->table('location')
    			->select('*')
    			->where('status_cd','normal')
    			->get();
    }

    public function getbyGolnm($location_nm) {
    	return $this->db->table('location')
    			->select('*')
    			->where('status_cd','normal')
    			->where('location_nm', $location_nm)
    			->get();
    }
}