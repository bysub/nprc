<?php

require APPPATH.'libraries/REST_Controller.php';

class Usermng extends REST_Controller{ 

  public function __construct(){
    parent::__construct();
    //load database
    $this->load->database();
    $this->load->library(array("form_validation"));
    $this->load->helper("security");
  }

  // POST
  public function index_post(){
    
    $searchType = $this->security->xss_clean($this->input->post("searchType"));    
    $searchType2 = $this->input->post("searchType");    
    $searchType3 = $this->input->post();    
    
    if($searchType == 'userList'){     
      $keyword = $this->security->xss_clean($this->input->post("keyword"));
      $result = $this->user_model->get_UserList($keyword); 
      
      $this->response(array(
        "status" => 1,
        "result" => true,
        "data" => $result,
        "message" => "gene Post Call Scussus"
      ), REST_Controller::HTTP_OK);
    } else if($searchType == 'Experiment') {
      $gene_cd = $this->security->xss_clean($this->input->post("gene_cd"));      
      $gene_gb = $this->security->xss_clean($this->input->post("gene_gb"));    
      $gene_tp = $this->security->xss_clean($this->input->post("gene_tp"));    
      $gene_pl = $this->security->xss_clean($this->input->post("gene_pl"));    

      $resultExperiment = $this->research_model->get_Experiment($gene_cd,$gene_gb,$gene_tp,$gene_pl );
      $this->response(array(
        "status" => 1,
        "result" => true,
        "data" => $resultExperiment,
        "message" => "Experiment Post Call Scussus"
      ), REST_Controller::HTTP_OK);
    }
  }
  
  // GET
  public function index_get($one = null, $two = null, $three = null){

      $this->load->view('templates/header');
      $this->load->view('users/userMng');
      $this->load->view('templates/footer');
  }
}

 ?>
