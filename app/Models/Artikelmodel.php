<?php namespace App\Models;

use CodeIgniter\Model;

class Artikelmodel extends Model
{
    protected $table      = 'artikel';
    protected $primaryKey = 'artikel_id ';
    protected $allowedFields = ['artikel_nm','keahlian_id','description','artikel_img', 'status_cd', 'created_dttm','created_user','update_dttm','update_user','nullified_dttm','nullified_user'];
    protected $kategorimodel;

    public function getbynormal() {
    	return $this->db->table('artikel')
    			->select('*')
    			->where('status_cd','normal')
    			->get();
    }

    public function getbyGolnm($artikel_nm) {
    	return $this->db->table('artikel')
    			->select('*')
    			->where('status_cd','normal')
    			->where('artikel_nm', $artikel_nm)
    			->get();
    }

    public function getkeahlian() {
    	return $this->db->table('keahlian')
    					->where('status_cd','normal')
    					->get();
    }

    public function getbyid($id){
    	return $this->db->table('artikel')
    					->where('artikel_id',$id)
    					->get();
    }
}