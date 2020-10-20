<?php namespace App\Models;

use CodeIgniter\Model;

class Admissionmodel extends Model
{
    protected $table      = 'his_patient_admission';
    protected $primaryKey = 'hospital_admission_id ';
    protected $allowedFields = ['admission_diag','person_id','admission_dttm','tensi','bbtb','lab','radiologi','mri','ekg','terapi','saran','status_cd', 'created_dttm','created_user','updated_dttm','updated_user_id','nullified_dttm','nullified_user'];
 

    public function getbynormal() {
    	return $this->db->table('his_patient_admission a')
                        ->join('persons b','b.person_id=a.person_id','left')
                        ->join('employee c','c.person_id=b.person_id','left')
                        ->join('pangkat d','d.pangkat_id=c.pangkat_id','left')
                        ->join('jabatan e','e.jabatan_id=c.jabatan_id','left')
                        ->join('kesatuan f','f.kesatuan_id=c.kesatuan_id','left')
                        ->where('a.status_cd','normal')
                        ->groupby('a.person_id')
                        ->orderby('admission_dttm','desc')
                        ->get();
    }

    public function getbyGolnm($admission_nm) {
    	return $this->db->table($this->table)
    			->select('*')
    			->where('status_cd','normal')
    			->where('admission_nm', $admission_nm)
    			->get();
    }

    public function getbypersonid($person_id) {
        return $this->db->table('his_patient_admission a')
                        ->join('persons b','b.person_id=a.person_id','left')
                        ->join('employee c','c.person_id=b.person_id','left')
                        ->join('pangkat d','d.pangkat_id=c.pangkat_id','left')
                        ->join('jabatan e','e.jabatan_id=c.jabatan_id','left')
                        ->join('kesatuan f','f.kesatuan_id=c.kesatuan_id','left')
                        ->where('a.status_cd','normal')
                        ->where('a.person_id',$person_id)
                        ->orderby('a.admission_dttm','DESC')
                        ->get();    

    }

    public function getadmissionid($id) {
        return $this->db->table($this->table)
                        ->select('MAX(admission_id) as admission_id')
                        ->where('person_id',$id)
                        ->where('status_cd','normal')
                        ->get();
    }

    public function getbyid($id) {
        return $this->db->table('his_patient_admission a')
                        ->join('persons b','b.person_id=a.person_id','left')
                        ->join('employee c','c.person_id=b.person_id','left')
                        ->join('pangkat d','d.pangkat_id=c.pangkat_id','left')
                        ->join('jabatan e','e.jabatan_id=c.jabatan_id','left')
                        ->join('kesatuan f','f.kesatuan_id=c.kesatuan_id','left')
                        ->where('a.status_cd','normal')
                        ->where('a.hospital_admission_id',$id)
                        ->orderby('a.admission_dttm','DESC')
                        ->get();    

    }

    public function insertadmission($data) {
        return $this->db->table($this->table)
                        ->insert($data);
    }

    public function updateadmission($id,$data) {
        return $this->db->table('his_patient_admission')
                        ->set($data)
                        ->where('hospital_admission_id',$id)
                        ->update();
    }
}