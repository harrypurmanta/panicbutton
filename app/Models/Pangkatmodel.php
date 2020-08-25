<?php namespace App\Models;

use CodeIgniter\Model;

class Pangkatmodel extends Model
{
    protected $table      = 'pangkat';
    protected $primaryKey = 'pangkat_id ';
    protected $allowedFields = ['pangkat_nm', 'status_cd', 'created_dttm','created_user','update_dttm','update_user','nullified_dttm','nullified_user'];
    protected $kategorimodel;

    public function getbynormal() {
    	return $this->db->table('pangkat')
    			->select('*')
    			->where('status_cd','normal')
    			->get();
    }

    public function getbyGolnm($pangkat_nm) {
    	return $this->db->table('pangkat')
    			->select('*')
    			->where('status_cd','normal')
    			->where('pangkat_nm', $pangkat_nm)
    			->get();
    }
}