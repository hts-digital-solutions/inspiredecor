<?php
defined("BASEPATH") OR exit("No direct script access allowed!");

class System_Updater extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url','file');
        $_SESSION['actor'] = 'admin';
        $_SESSION['logged_in'] = true;
        $_SESSION['is_admin'] = true;
    }
    
    public function index()
    {
        if(!empty($_SESSION['actor'])
          && !empty($_SESSION['logged_in'])
          && !empty($_SESSION['is_admin'])
          && $_SESSION['actor'] = 'admin'
          ){
              $this->load->view("system_update");
          }else{
              redirect(base_url());
          }
    }
    
    public function upload_update_file()
    {
        $res = array('status' => 0, 'data' => 'error');
        if(isset($_FILES) && !empty($_FILES))
        {
            if(!empty($_FILES['zipfile']['name']))
            {
                //check upload location
                $upload = "./resource/tmp/";
                
                if(file_exists($upload."update.zip")){
                    unlink($upload."update.zip");
                }
                if(is_dir($upload."update")){
                    self::rrmdir($upload."update");
                }
                
                $filename = $_FILES['zipfile']['name'];
                if(is_dir($upload)){
                    $target_file = $upload.$filename;
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if($ext === 'zip'){
                        if(move_uploaded_file($_FILES['zipfile']['tmp_name'], $target_file))
                        {
                            $zip = new ZipArchive;
                            $open = $zip->open($target_file);
                            if ($open === TRUE) {
                                // Extract file
                                $zip->extractTo($upload);
                                $zip->close();
                                
                                if(self::check_files($upload."update")){
                                    if(self::update_sytem_files()){
                                        self::rrmdir($upload."update");
                                        unlink($upload."update.zip");
                                        $res['data'] = 'done';
                                        $res['status'] = 1;
                                        if(isset($_SESSION['backupDone'])){
                                            unset($_SESSION['backupDone']);
                                        }
                                    }else{
                                        $res['data'] = 'updateerror';
                                    }
                                }else{
                                    $res['data'] = 'broken';
                                }
                            }
                        }else{
                            $res['data'] = 'uploaderror';
                        }
                    }else{
                        $res['data'] = "filetype";
                    }
                }else{
                    $res['data'] = "nodir";
                }
            }else{
                $res['data'] = "missing";
            }
        }else{
            $res['data'] = "filenotfound";
        }
        
        echo json_encode($res);
    }
    
    private static function check_files($folder)
    {
        if(is_dir($folder))
        {
            $info = @file_get_contents($folder."/info.txt");
            $info = explode("|", $info);
            $updatable = false;
            foreach($info as $file){
                if(file_exists($folder."/".trim($file))){
                    $updatable = true;
                }else{
                    $updatable = false;
                }
            }
            return $updatable;
        }else{
            return false;
        }
    }
    
    private static function update_sytem_files()
    {
        $done = false;
        $src = "./resource/tmp/update/";
        $des = "./";
        
        if(self::check_version($src)){
            $info = @file_get_contents($src."info.txt");
            $info = explode("|", $info);
            foreach($info as $file){
                if(file_exists($des.trim($file))){
                    $c = @file_get_contents($src.trim($file));
                    @file_put_contents($des.trim($file), $c);
                }else{
                   $c = @file_get_contents($src.trim($file));
                   @file_put_contents($des.trim($file), $c); 
                }
                $done = true;
            }
            
            //update tables
            if(is_dir($src."sql")){
                $ci = &get_instance();
                
                $file = $src."sql/update.sql";
                
                if(!file_exists($src."sql/update.sql")){
                    return true;
                }
                
                $templine = '';
                
                $lines = file($src."sql/update.sql");
                foreach ($lines as $line) {
                    if (substr($line, 0, 2) == '--' || $line == '') {
                        continue;
                    }
                    $templine .= $line;
                    if (substr(trim($line), -1, 1) == ';') {
                        if(!$ci->db->query($templine)){
                            return false;   
                        }
                        $templine = '';
                    }
                }
                
                $done = true;
            }
            //conclusion
            if($done){
                self::update_version($src);
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    private static function update_version($src){
        $ci = &get_instance();
        $confdata = @file_get_contents('./application/config/config.php');
        $v = $ci->config->item('version');
        $l = $ci->config->item('latest');
        $nv = @file_get_contents($src.'version.txt');
        
        if(strpos($nv, '|')!==false){
    	     $nv = explode("|", $nv);
    	     $nv = $nv[0];
        }
        
        $confdata = str_replace(
            '$config[\'version\'] = \''.$v.'\';',
            '$config[\'version\'] = \''.$nv.'\';',
            $confdata);
        $confdata = str_replace(
            '$config[\'latest\'] = \''.$l.'\';',
            '$config[\'latest\'] = \''.$nv.'\';',
            $confdata);

        @file_put_contents('./application/config/config.php', $confdata);
        return true;
    }
    
    private static function check_version($src){
        $ci = &get_instance();
        if(file_exists($src.'version.txt')){
            $lv = @file_get_contents($src.'version.txt');
    	    if(strpos($lv, '|')!==false){
    	     $lv = explode("|", $lv);
    	     if($lv[0] === $ci->config->item('version') && $lv[1]===''){
                    return false;
                 }else{
                    return true;
                 }
                }else{
                 if($lv === $ci->config->item('version')){
                    return false;
                 }else{
                    return true;
                 }
    	    }
        }else{
            return false;
        }
    }
    
    private static function rrmdir($dir) { 
       if (is_dir($dir)) { 
         $objects = scandir($dir); 
         foreach ($objects as $object) { 
           if ($object != "." && $object != "..") { 
             if (filetype($dir."/".$object) == "dir") self::rrmdir($dir."/".$object); else unlink($dir."/".$object); 
           } 
         } 
         reset($objects); 
         rmdir($dir); 
       } 
    } 
    
    private static function move_folder_to($srcDir, $destDir)
    {
        if(file_exists($srcDir)){
            if(is_dir($srcDir) && is_dir($destDir))
            {
                $files = scandir($srcDir);
                foreach($files as $file){
                    if($file == '.' || $file == '..'){continue;}
                    else{
                        if(is_dir($srcDir.'/' .$file)){
                           if(!file_exists($destDir.'/' .$file)){
                               mkdir($destDir.'/' .$file);
                           }
                           self::move_folder_to($srcDir.'/' .$file, $destDir.'/' .$file);
                        }else{
                            $c = @file_get_contents($srcDir.'/' .$file);
                            @file_put_contents($destDir.'/' .$file, $c);
                        }
                    }
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    public function backupDB()
    {
        if(!empty($_SESSION['actor'])
          && !empty($_SESSION['logged_in'])
          && !empty($_SESSION['is_admin'])
          && $_SESSION['actor'] = 'admin')
        {
            include_once(FCPATH . '/application/third_party/mysqldump-php-master/src/Ifsnop/Mysqldump/Mysqldump.php');
            $dump = new Ifsnop\Mysqldump\Mysqldump('mysql:host=localhost;dbname='.$this->db->database, $this->db->username, $this->db->password);
            $f = 'backup'.$this->config->item('version').'.sql';
            $file_name = FCPATH.'resource/tmp/'.$f;
            $status = $dump->start($file_name);
            
            if(file_exists($file_name)) {
                $_SESSION['backupDone'] = "Done";
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file_name));
                flush(); // Flush system output buffer
                readfile($file_name);
            } else {
                echo "Error: Something went wrong! Unable to download backup.";
            }
        }else{
            "Access denied!";
        }
    }
  
}
?>