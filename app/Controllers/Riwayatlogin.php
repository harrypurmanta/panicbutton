<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Riwayatmodel;
require  '/var/www/html/panicbutton/app/Libraries/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Riwayatlogin extends BaseController
{

	protected $riwayatmodel;
	protected $spreadsheet;
	public function __construct(){
		$this->riwayatmodel = new Riwayatmodel();
		$this->spreadsheet = new Spreadsheet();
		$this->session = \Config\Services::session();
		$this->session->start();
	}
	public function index(){
		if (session()->get('user_nm') == "") {
            session()->setFlashdata('error', 'Anda belum login! Silahkan login terlebih dahulu');
            return redirect()->to(base_url('/'));
        }
		$data = [
			'title' => 'Admin Dashboard',
			'subtitle' => 'Riwayat User',
			'riwayat' => $this->riwayatmodel->getbynormal()->getResult()
		];
		return view('riwayatlogin',$data);
	}

	public function exportexcel() {
		$res = $this->riwayatmodel->getbynormal()->getResult();
		
		$this->spreadsheet->setActiveSheetIndex(0)
               ->setCellValue('A1', 'No')
               ->setCellValue('B1', 'Nama Anggota')
               ->setCellValue('C1', 'User ID Device')
               ->setCellValue('D1', 'Tanggal Login')
               ->setCellValue('E1', 'Tanggal Logout');
    
	    $column = 2;
	    $no = 1;
	    foreach ($res as $key) {
	    	$this->spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, $no++)
                    ->setCellValue('B' . $column, $key->person_nm)
                    ->setCellValue('C' . $column, $key->user_id_device)
                    ->setCellValue('D' . $column, $key->session_login)
                    ->setCellValue('E' . $column, $key->session_logout);
        	$column++;
	    }
	    $writer = new Xlsx($this->spreadsheet);
    	$fileName = 'Data_History_Login'.date('Y-m-d H:i:s');
    	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    	header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
    	header('Cache-Control: max-age=0');
    	$writer->save('php://output');
	}

}
