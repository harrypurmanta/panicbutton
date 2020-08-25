<?php namespace App\Models;

use CodeIgniter\Model;

class Jabatanmodel extends Model
{
    protected $table      = 'jabatan';
    protected $primaryKey = 'jabatan_id ';
    protected $allowedFields = ['jabatan_nm', 'status_cd', 'created_dttm','created_user','update_dttm','update_user','nullified_dttm','nullified_user'];
    protected $kategorimodel;

    public function getbynormal() {
    	return $this->db->table('jabatan')
    			->select('*')
    			->where('status_cd','normal')
    			->get();
    }

    public function getbyGolnm($jabatan_nm) {
    	return $this->db->table('jabatan')
    			->select('*')
    			->where('status_cd','normal')
    			->where('jabatan_nm', $jabatan_nm)
    			->get();
    }
}