<?php namespace App\Models;

use CodeIgniter\Model;

class Admissionmodel extends Model
{
    protected $table      = 'his_patient_admission';
    protected $primaryKey = 'admission_id ';
    protected $allowedFields = ['admission_id', 'status_cd', 'created_dttm','created_user','update_dttm','update_user','nullified_dttm','nullified_user'];
    protected $kategorimodel;

    public function getbynormal() {
    	return $this->db->table('his_patient_admission a')
                        ->join('persons b','b.person_id=a.person_id', 'left')
                        ->where('a.status_cd','normal')
                        ->get();
    }

    public function getbyGolnm($admission_nm) {
    	return $this->db->table($this->table)
    			->select('*')
    			->where('status_cd','normal')
    			->where('admission_nm', $admission_nm)
    			->get();
    }
}