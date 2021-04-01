<?php

require APPPATH.'libraries/REST_Controller.php';

class Fastqfile extends REST_Controller{ 

  public function __construct(){
    parent::__construct();
    $this->load->helper("security");
  }

  // POST
  public function index_post(){
    $dir_path = "/uploads/fastq";
    $searchType = $this->security->xss_clean($this->input->post("searchType"));  
    $folder = [];

    if($searchType == 'folder'){
      $folder = $this->folder($dir_path , 1 , 0 ) ; 

      $this->response(array(
          "status" => 1,
          "result" => true,
          "data" => $folder ,
          "message" => "Experiment Post Call Scussus"
          ), REST_Controller::HTTP_OK);
    } else {
      $dir_path = $this->security->xss_clean($this->input->post("filePath"));
      
      $folder = $this->fileList($dir_path ) ; 
      $this->response(array(
        "status" => 1,
        "result" => true,
        "data" => $folder ,
        "message" => "Experiment Post Call Scussus"
        ), REST_Controller::HTTP_OK);
    }
  }  
  
  function folder( $src, $lvl , $parentId ) { 
    $FileList = [];
    $fileCnt = 0; 

    $dir = opendir('.'.$src);  
    while(false !== ( $file = readdir($dir)) ) {   
        if (( $file != '.' ) && ( $file != '..' )) {          
            $fileDirLvl = $lvl ;                
            if ( is_dir('.'.$src . '/' . $file) ) {       
                $fileCnt++; 
                $fileDirLvl ++;          
                $thisId = $parentId.$fileDirLvl.$fileCnt;
                $fileInfo['parentId']   =  $parentId;
                $fileInfo['thisId']     =  $thisId;                
                $fileInfo['filePath']   = $src.'/'.$file;
                $fileInfo['viewNm']     =  $file;
                
                array_push($FileList,$fileInfo);
                $FileList = array_merge($FileList, $this->folder($src . '/' . $file , $fileDirLvl , $thisId) );
            }
        }  
    }  
    closedir($dir);
    return $FileList;
  }
  
  function fileList( $src ) { 
    $FileList = [];
    $fileCnt = 0; 
    $dir = opendir('.'.$src);  
    while(false !== ( $file = readdir($dir)) ) {   
        if (( $file != '.' ) && ( $file != '..' ) && !is_dir('.'.$src . '/' . $file) ) {   
          $fileCnt ++;
          $fileInfo['fileId']     =  $fileCnt;                
          $fileInfo['filePath']   = $src.'/'.$file;
          $fileInfo['fileNm']     =  $file;
          array_push($FileList,$fileInfo);
        }  
    }  
    closedir($dir);
    return $FileList;       
  }
}

 ?>
