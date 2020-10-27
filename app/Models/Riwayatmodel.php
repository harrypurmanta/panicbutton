<?php namespace App\Models;

use CodeIgniter\Model;

class riwayatmodel extends Model
{

    public function getbynormal() {
    	return $this->db->table('session_login_mobile a')
    			->select('*')
    			->join('users b','b.user_id=a.user_id','left')
    			->join('persons c','c.person_id=b.person_id')
    			->get();
    }

 
}