<?php namespace App\Models;

use CodeIgniter\Model;

class Kesatuanmodel extends Model
{
    protected $table      = 'kesatuan';
    protected $primaryKey = 'kesatuan_id ';
    protected $allowedFields = ['kesatuan_nm', 'status_cd', 'created_dttm','created_user','update_dttm','update_user','nullified_dttm','nullified_user'];
    protected $kategorimodel;

    public function getbynormal() {
    	return $this->db->table('kesatuan')
    			->select('*')
    			->where('status_cd','normal')
    			->get();
    }

    public function getbyGolnm($kesatuan_nm) {
    	return $this->db->table('kesatuan')
    			->select('*')
    			->where('status_cd','normal')
    			->where('kesatuan_nm', $kesatuan_nm)
    			->get();
    }
}