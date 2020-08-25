<?php namespace App\Models;

use CodeIgniter\Model;

class golonganmodel extends Model
{
    protected $table      = 'golongan';
    protected $primaryKey = 'golongan_id ';
    protected $allowedFields = ['golongan_nm', 'status_cd', 'created_dttm','created_user','update_dttm','update_user','nullified_dttm','nullified_user'];
    protected $kategorimodel;

    public function getbynormal() {
    	return $this->db->table('golongan')
    			->select('*')
    			->where('status_cd','normal')
    			->get();
    }

    public function getbyGolnm($golongan_nm) {
    	return $this->db->table('golongan')
    			->select('*')
    			->where('status_cd','normal')
    			->where('golongan_nm', $golongan_nm)
    			->get();
    }
}