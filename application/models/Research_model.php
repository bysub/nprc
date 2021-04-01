<?php

class Research_model extends CI_Model{

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  
  public function get_genecount($gene_gb=null , $gene_tp=null  , $gene_pl=null   , $keyword =null){
    $sql = "SELECT count(1) as totalcount
              FROM tb_gene A
             WHERE 1=1 "; 
    $addseql = ""; 
    if(!empty($gene_gb)) {
      $addseql = $addseql." AND A.gene_gb = '".$gene_gb."'" ;
    }

    if(!empty($gene_pl)) {
      $addseql = $addseql." AND A.gene_pl = '".$gene_pl."'" ;
    }

    if(!empty($gene_tp)) {
      $addseql = $addseql." AND A.gene_tp = '".$gene_tp."'" ;
    }

    
    if(!empty($keyword)) {
      $addseql = $addseql ." AND ( A.gene_cd LIKE CONCAT( '%', '".$keyword."' ,'%')  OR A.gene_nm LIKE CONCAT( '%', '".$keyword."' ,'%') ) ";
    }
    $sql = $sql.$addseql;
    
    
    // log_message('error',"sql :".$sql);
    $query = $this->db->query($sql); // $this->db->get_where('posts', array('slug' => $slug));

    return $query->row_array();
    
  }

  public function get_gene($gene_gb=null , $gene_tp=null  , $gene_pl=null , $keyword =null){ // },$page=null,$rows=null){
    // log_message('error',"get_gene : gene_gb=> ".$gene_gb." ,gene_tp=>".$gene_tp." ,gene_pl=>".$gene_pl." ,keyword=>".$keyword);
    // log_message('error',"get_gene : gene_gb=> ".$gene_gb." ,gene_tp=>".$gene_tp." ,gene_pl=>".$gene_pl." ,keyword=>".$keyword." ,page=>".$page." ,rows=>".$rows);
    
    $resultcount = $this->research_model->get_genecount($gene_gb,$gene_tp,$gene_pl,$keyword);
    // log_message('error',"resultcount :".$resultcount['totalcount']);

    $sql = "SELECT A.gene_idx AS gene_idx
				        , A.gene_cd 
                , A.gene_nm 
                , A.gene_gb 
                , A.chr  AS chr
                , A.pos_start AS pos_start
                , A.pos_end AS pos_end
                , A.strand_way 
                , CONVERT(A.`desc` USING UTF8) AS `desc`
                , A.gene_tp
                , A.gene_pl
                , ( SELECT CD1.DTL_NM FROM TB_CODE_DTL CD1 WHERE CD1.GRP_CD = 'EXTP' AND CD1.DTL_CD = IFNULL( A.gene_tp ,'-')  ) AS gene_tp_nm
                , ( SELECT CD2.DTL_NM FROM TB_CODE_DTL CD2 WHERE CD2.GRP_CD = 'EXPL' AND CD2.DTL_CD = IFNULL( A.gene_pl ,'-')  ) AS gene_pl_nm
                , ( SELECT CD3.DTL_NM FROM TB_CODE_DTL CD3 WHERE CD3.GRP_CD = 'PRTP' AND CD3.DTL_CD = IFNULL( A.gene_gb ,'-')  ) AS gene_gb_nm
                , @ROWNUM := @ROWNUM + 1 AS rownum
              FROM tb_gene A
                  , ( SELECT @ROWNUM := 0 ) NUM
             WHERE 1=1 "; 

    $addseql = ""; 
    if(!empty($gene_gb)) {
      $addseql = $addseql." AND A.gene_gb = '".$gene_gb."'" ;
    }

    if(!empty($gene_pl)) {
      $addseql = $addseql." AND A.gene_pl = '".$gene_pl."'" ;
    }

    if(!empty($gene_tp)) {
      $addseql = $addseql." AND A.gene_tp = '".$gene_tp."'" ;
    }

    
    if(!empty($keyword)) {
      $addseql = $addseql ." AND ( A.gene_cd LIKE CONCAT( '%', '".$keyword."' ,'%')  OR A.gene_nm LIKE CONCAT( '%', '".$keyword."' ,'%') OR A.`desc` LIKE CONCAT( '%', '".$keyword."' ,'%') ) ";
    }

//     $startUnit = (int) ( ( $page -1 ) * $rows) ; 
    if($addseql == "" || $resultcount['totalcount'] > 30000 ) {
      $limit =  " ORDER BY A.gene_cd , A.gene_nm LIMIT 0 , 30000";
    } else {
      $limit =  " ORDER BY A.gene_cd , A.gene_nm"; //  limit ".$startUnit." , ".$rows;// 1,25";// 
    }
    $sql = $sql.$addseql.$limit;
    
    // log_message('error',"sql :".$sql);
    
    $query = $this->db->query($sql);
    
    return $query->result_array();
  }
  
  public function get_Experiment($gene_cd=null ,$gene_gb=null , $gene_tp=null  , $gene_pl=null ){ 
    // log_message('error',"get_Experiment : gene_cd=> ".$gene_cd);
    $sql = "SELECT a.gene_cd , b.gene_nm , a.exp_cd , c.exp_nm, CAST( a.result AS double ) AS resutl_val
              from tb_result a 
                  INNER JOIN tb_gene b ON a.gene_cd = b.gene_cd  AND a.result_gb = b.gene_gb AND a.result_tp = b.gene_tp AND a.result_pl = b.gene_pl
                  INNER JOIN tb_experiment c ON a.exp_cd = c.exp_cd
             WHERE a.gene_cd = '".$gene_cd."'" ;  
             
    if(!empty($gene_gb)) {
      $sql = $sql." AND a.result_gb = '".$gene_gb."'" ;
    }
    if(!empty($gene_tp)) {
      $sql = $sql." AND a.result_tp = '".$gene_tp."'" ;
    }
    if(!empty($gene_pl)) {
      $sql = $sql." AND a.result_pl = '".$gene_pl."'" ;
    }
    
    $sql = $sql." ORDER BY a.exp_cd , c.exp_nm";
    // log_message('error',"4=> ".$sql); 
 
    $query = $this->db->query($sql ); // ,array($gene_cd));
    return $query->result_array();
  }

}

 ?>
