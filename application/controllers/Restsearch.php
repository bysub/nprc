<?php

require APPPATH.'libraries/REST_Controller.php';

class Restsearch extends REST_Controller{ 

  public function __construct(){
    parent::__construct();
    //load database
    $this->load->database();
    $this->load->model(array("research_model"));
    $this->load->library(array("form_validation"));
    $this->load->helper("security");
  }

  // POST
  public function index_post(){
    // echo str_repeat(" ", 10000);
    // ob_start();
    $searchType = $this->security->xss_clean($this->input->post("searchType"));    

    if($searchType == 'gene'){     
      $code_gb = $this->security->xss_clean($this->input->post("code_gb"));
      $code_extp = $this->security->xss_clean($this->input->post("code_extp"));
      $code_expl = $this->security->xss_clean($this->input->post("code_expl"));
      $keyword = $this->security->xss_clean($this->input->post("keyword"));
      // $page = (int)$this->input->post("page"); // $this->security->xss_clean($this->input->post("page"));
      // $rows = (int)$this->input->post("rows") ; // $this->security->xss_clean($this->input->post("rows"));
      // if(empty($page)) $page = 1;
      // if(empty($rows)) $rows = 25;
      $result = $this->research_model->get_gene($code_gb,$code_extp,$code_expl,$keyword); // ,$page,$rows);
      // $resultcount = $this->research_model->get_genecount($code_gb,$code_extp,$code_expl,$keyword);
      
      $this->response(array(
        "status" => 1,
        "result" => true,
        "data" => $result,
        // "totalCount" => $resultcount['totalCount'],
        "message" => "gene Post Call Scussus"
      ), REST_Controller::HTTP_OK);
      ob_end_clean();
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
      // Get 변수 담을 영역 선언
      $data['sgb'] = "";
      $data['stp'] = "";
      $data['spl'] = "";

      $search_gb = $this->security->xss_clean($this->input->get("sgb"));
      $search_type = $this->security->xss_clean($this->input->get("stp"));
      $search_plan = $this->security->xss_clean($this->input->get("spl")); 
      // Get 변수 세팅 
      if(!empty($search_gb))   $data['sgb'] = $search_gb;
      if(!empty($search_type)) $data['stp'] = $search_type;
      if(!empty($search_plan)) $data['spl'] = $search_plan;
      // 공통코드 가져오기
      $data['code1'] = $this->common_model->get_code('PRTP');
      $data['code2'] = $this->common_model->get_code('EXPL');       
      $data['code3'] = $this->common_model->get_code('EXTP');
      
      $data['setvalue']['keyword'] = $this->security->xss_clean($two);

      $this->load->view('templates/header');
      $this->load->view('research/view',$data);
      $this->load->view('templates/footer');
  }
}

 ?>
