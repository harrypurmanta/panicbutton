<?php


class Ciesign 
{

    /**
     * @var string
     * @access private 
     */
    private $dirLib;

    /**
     * @var string
     * @access private 
     */
    private $dirTmp;

    /**
     * 
     * @var string
     * @access private
     */
    private $directoryName;

    /**
     * 
     * @var string
     * @access private
     */
    private $filename;

    /**
     * @var string
     * @access private 
     */
    private $library = '/esign-client-cli-1.0-SNAPSHOT-jar-with-dependencies.jar';


    /**
     * @var string
     * @access private
     */
    private $error;

    /**
     * 
     */
    private $pdf;

    /**
     * 
     */
    private $spesimen = '';
    private $spesimenqr = '';
    /**
     * @var string
     * @access private
     */
    private $suffixName = '';

    /**
     * 
     */
    private $visualisasi = ' -t invisible';
    private $visualisasiqr = ' -t invisible';
    /**
     * 
     */
    public function __construct(){
        $this->dirLib = dirname(dirname(__FILE__)) . '/library';
        $this->dirTmp = dirname(dirname(__FILE__)) . '/tmp';
    }

    /**
     * 
     */
    public function checkStatus($nik)
    {
        $nik = preg_replace('/[^\w]/', '', $nik);
        $command = 'java -jar ' . $this->dirLib . $this->library . ' -m cek_status_user -nik ' . $nik . ' -ot pretty';
        exec($command, $val, $err);
        
        if($err == 0 || $err == 3) {
            $respon = $this->response($val);
            
            if(!isset($respon)){
                $this->error = 'tidak dapat terhubung dengan server BSrE';
                return false;
            }

            if(isset($respon->error)) {
                $this->error = $respon->error;
                return false;
            }
            return $respon->message;
        }else {
            $this->error = 'Gagal Cek Status User';
            return false;
        }
    }

    public function clearTmp()
    {
        $files = glob($this->dirTmp . '/PDF/*'); 
        foreach($files as $file){ 
        if(is_file($file))
            unlink($file); 
        }

        $files2 = glob($this->dirTmp . '/EMPTY_SIG/*'); 
        foreach($files2 as $file2){ 
        if(is_file($file2))
            unlink($file2); 
        }
    }

    /**
     * 
     * @access public 
     */
    function getError()
    {
       return $this->error;
    }

    /**
     * 
     */
    // private function getBasePath() { 
    //     $projectName = explode('/',$_SERVER['PHP_SELF'])[1];
    //     $basePath = $_SERVER['DOCUMENT_ROOT'] . $projectName;
    //     return $basePath; 
    // } 
    
    private function getBasePath() { 
        $projectName = explode('/',$_SERVER['PHP_SELF'])[1];
        $basePath = $_SERVER['DOCUMENT_ROOT'];
        return $basePath; 
    } 

    public function log($message)
    {    
        $path = $this->dirLib . '/log/error.log';

        $writeLog = 'Waktu : ' . date("Y-m-d h:i:s a") . PHP_EOL 
                  . 'Dokumen : ' . $this->pdf . PHP_EOL
                  . 'Pesan Error : '.PHP_EOL ;

        if(is_array($message)){
            foreach ($message as $m) {
                $writeLog .= $m . PHP_EOL;
            }
        }else{
            $writeLog .= $message . PHP_EOL;
        }
        
        $writeLog .= '======================================'
                   . '======================================'
                   . '======================================' . PHP_EOL;

		try{
            $tmp_f = fopen($path ,'a+');
            fwrite($tmp_f, $writeLog);
            fclose($tmp_f);	
        }catch(Exception $e){
            $this->error = 'File Log tidak dapat dibaca';
            return;
        }
    }

    /**
     * 
     */
    private function moveFile($file = '')
    {
        copy($file, $this->directoryName . '/' . $this->filename . $this->suffixName . '.pdf');
        $filename = basename($file, '.pdf');
        unlink($this->dirTmp . '/PDF/' . $filename . '.pdf');
        unlink($this->dirTmp . '/EMPTY_SIG/' . $filename . '.pdf');
        unlink($this->dirTmp . '/SIGNED/' . $filename . '.pdf');
    }
    public function moveFilesigned($file = '', $signeddir='',$filename='')
    {
        $basePath = $this->getBasePath();
        copy($basePath.'/'.$file, $basePath. '/' .$signeddir . '/' . $filename . $this->suffixName . '.pdf');
        //unlink($basePath. '/' .$file);
    }


    public function moveFilesignedreg($file = '', $signeddir='',$filename='')
    {
        $basePath = $this->getBasePath();
        copy($basePath.'/'.$file, $basePath. '/' .$signeddir . '/' . $filename . $this->suffixName . '.pdf');
        unlink($basePath. '/' .$file);
    }

    public function copyTotmp($file = '',$tmpdir='',$filename='')
    {
        $basePath = $this->getBasePath();
        copy($basePath.'/'.$file, $basePath.'/'.$tmpdir . '/' . $filename . '.pdf');
        
    }

    /**
     * 
     */
    public function register($nik, $nama, $email, $telp, $kota, $prov, $nip, $jabatan, $unit, $ktp, $rekomendasi, $visualisasi = null)
    {
        if(!is_file($ktp)) return 'File KTP tidak ditemukan';
        if(!is_file($rekomendasi)) return 'Surat Rekomendasi tidak ditemukan';

        $command = 'java -jar ' . $this->dirLib . $this->library . ' -m registrasi '
                 . '-nik ' . $nik . ' -nama ' . $nama . ' -email ' . $email . ' -telp ' . $telp . ' -kota ' . $kota . ' -prov ' . $prov 
                 . ' -nip ' . $nip . ' -jabatan ' . $jabatan . ' -unit ' . $unit . ' -ktp ' . $ktp . ' -rekomendasi ' . $rekomendasi ;

        if(!is_null($visualisasi)) {
            if(!is_file($visualisasi)) return 'Visualisasi tanda tangan tidak ditemukan';
            $command .= ' -visualisasi ' . $visualisasi ;
        }
        $command .= ' -ot pretty';

        exec($command, $val, $err);
        
        if($err == 0 || $err == 3) {
            $respon = $this->response($val);

            if(!isset($respon)){
                $this->error = 'tidak dapat terhubung dengan server BSrE';
                return false;
            }

            if(isset($respon->error)) {
                $this->error = $respon->error;
                return false;
            }
            return $respon;
            
        }else {
            $this->error = 'Gagal jalankan modul Penerbitan Sertifikat Elektronik';
            return false;
        }
    }

    /**
     * 
     */
    public function setDirOutput($dir, $create = true)
    {
        $basePath = $this->getBasePath();
        
        if(! is_dir($basePath . '/' . $dir) && $create){
            if(!@mkdir($basePath . '/' . $dir)){
                $this->error = 'Gagal membuat direktori ' . $basePath . '/' . $dir;
                $this->log($this->error);
                return;
            }
        }elseif (! is_dir($basePath. '/' . $dir) && !$create){
            $this->error = 'Direkrori ' . $basePath . '/' . $dir . ' tidak ditemukan';
            $this->log($this->error);
            return;
        }
        // atur ulang nama direktori
        $this->directoryName = $basePath . '/' . $dir;
        //error_log(print_r($this->directoryName,true)); 
    }

    /**
     * 
     */
    public function setDocument($pdf)
    {   
        $basePath = $this->getBasePath();
        $ext = pathinfo($pdf, PATHINFO_EXTENSION);
        $this->pdf = $basePath.'/'.$pdf;
        $this->filename = basename($this->pdf, '.' .$ext);
        $this->directoryName = realpath(dirname($this->pdf));

        if(!is_file($this->pdf)){
            $this->error = 'File ' . $this->pdf . ' tidak ditemukan';
            $this->log($this->error);
            return;
        }
        if( $ext != 'pdf'){
            $this->error = 'Dokumen ' . $this->pdf . ' bukan merupakan File PDF';
            $this->log($this->error);
            return;
        }
        if(@file_get_contents($this->pdf) === false){
            $this->error = 'Dokumen ' . $this->pdf . ' tidak bisa di buka';
            $this->log($this->error);
            return;
        }
    }

    /**
     * 
     */
    public function setSuffixFileName($suffix)
    {
        $this->suffixName = $suffix;
    }

    public function setAppearance(
        $x = '',
        $y = '',
        $width = '',
        $height = '',
        $page = '',
        $spesimen = null,
        $qr = null)
    {
        $basePath = $this->getBasePath();

        if (!is_null($spesimen)) {
            $this->visualisasi = ' -t visible -i TRUE';
            $this->spesimen = ' -v ' . $basePath . $spesimen .' -page ' . $page . ' -x ' . $x . ' -y ' . $y . ' -width ' . $width . ' -height ' . $height;
        } elseif(!is_null($qr)){
            $this->visualisasiqr = ' -t visible -i FALSE';
            $this->spesimenqr = ' -qr ' . $qr .' -page ' . $page;
        }else {
            $this->visualisasi = ' -t invisible';
        }
       
        return $this->spesimen;

    }

    /**
     * 
     */
    public function sign($nik, $pass)
    {
        if(!is_null($this->error)) return false;

        // $command = '/usr/lib/jre1.8.0_241/bin/java -jar ' . $this->dirLib . $this->library . ' -m sign -f  ' . $this->pdf . ' -p ' . trim($pass) . ' -nik ' . preg_replace( '/[^0-9]/', '', $nik ) . $this->visualisasi . $this->spesimen .' -d ' . $this->dirTmp . ' -ot pretty';
        $command = 'java -jar ' . $this->dirLib . $this->library . ' -m sign -f  ' . $this->pdf . ' -p ' . trim($pass) . ' -nik ' . preg_replace( '/[^0-9]/', '', $nik ) . $this->visualisasi . $this->spesimen .' -d ' . $this->dirTmp . ' -ot pretty';
        error_log(print_r($command,true));
        exec($command, $val, $err);
        if($err == 0 || $err == 3) {
            $respon = $this->response($val);
            
            if(!isset($respon)){
                $this->error = 'tidak dapat terhubung dengan server BSrE';
                return false;
            }

            if(isset($respon->error)){
                $this->error = $respon->error;
                $this->clearTmp();
                $this->log($this->error);
                return false;
                error_log(print_r($this->error,true)); 
            }
            $this->moveFile($respon);
            return true;
        }else {
            $this->error = 'Gagal jalankan modul Tanda Tangan Elektronik';
            return false;
        }
         error_log(print_r($this->error,true)); 
    }

    private function response($data)
    {
        $data = implode('', $data);
        return json_decode($data);
    }

    public function verifikasi($doc)
    {
        if(!is_file($doc)){
            $this->error = 'File tidak ditemukan';
            return false;
        }

        if(pathinfo($doc, PATHINFO_EXTENSION) != 'pdf'){
            $this->error = 'Dokumen ini bukan merupakan File PDF';
            return false;
        }

        $command = 'java -jar ' . $this->dirLib . $this->library . ' -m verifikasi -f ' . escapeshellarg($doc) . ' -ot pretty';
        exec($command, $val, $err);
        
        if($err == 0 || $err == 3) {
            $respon = $this->response($val);
            if(isset($respon->error)){
                $this->error = $respon->error;
                return false;
            }
            return $respon;
        }else {
            $this->error = 'Gagal Proses Verifikasi Tanda Tangan';
            return false;
        }
       
    }

}

