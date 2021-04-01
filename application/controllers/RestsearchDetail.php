<?php

require APPPATH.'libraries/REST_Controller.php';

class Restsearchdetail extends REST_Controller{ 

  public function __construct(){
    parent::__construct();
    //load database
    $this->load->database();
    $this->load->model(array("research_model"));
    // $this->load->model(array("common_model"));
    $this->load->library(array("form_validation"));
    $this->load->helper("security");
  }

  // POST
  public function index_post(){
    log_message('error','post_Experiment');
     $searchType = $this->security->xss_clean($this->input->post("searchType"));   
      $gene_cd = $this->input->post("gene_cd") ; // $this->security->xss_clean($this->input->post("gene_cd"));      
      $resultExperiment = $this->research_model->get_Experiment($gene_cd);
      $this->response(array(
        "status" => 1,
        "result" => true,
        "data" => $resultExperiment,
        "message" => "Experiment Post Call Scussus"
      ), REST_Controller::HTTP_OK);
  }
}

 ?>
