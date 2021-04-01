<?php
	class User_model extends CI_Model{
		public function register($enc_password){
			// User data array
			$data = array(
				'user_id' => $this->input->post('user_id'),
				'user_nm' => $this->input->post('user_nm'),
				'org_nm' => $this->input->post('org_nm'),
				'org_dept_nm' => $this->input->post('org_dept_nm'),
				'org_position' => $this->input->post('org_position'),
				'user_hp' => $this->input->post('user_hp'),
				'user_email' => $this->input->post('user_email'),
                'user_pw' => $enc_password
			);

			// Insert user
			return $this->db->insert('tb_user', $data);
		}

		// Log user in
		public function login($user_id, $password){
			// Validate
			$this->db->where('user_id', $user_id);
			$this->db->where('user_pw', $password);
			$this->db->where('use_yn', 'Y');

			$result = $this->db->get('tb_user');

			if($result->num_rows() == 1){
				return $result->row_array();
			} else {
				return false;
			}
		}
		
		public function get_UserList($keyword=null  ){ 
			
			$sql = "SELECT a.user_id , a.user_nm , a.org_nm, a.org_dept_nm , a.org_position , a.user_hp , a.user_email , a.use_yn , DATE_FORMAT(a.create_dt , '%Y-%m-%d %H:%i') AS create_dt
			              , @ROWNUM := @ROWNUM + 1 AS rownum
					  FROM tb_user a
                         , ( SELECT @ROWNUM := 0 ) NUM
				     WHERE 1=1" ;  
					 
			if(!empty($keyword)) {
			  $sql = $sql." AND ( a.user_id = '".$keyword."' OR a.user_nm = '".$keyword."' OR a.org_nm = '".$keyword."' OR a.org_dept_nm = '".$keyword."')"  ;
			}
			
			$sql = $sql." ORDER BY a.user_id , a.user_nm";
		 
			$query = $this->db->query($sql );
			return $query->result_array();
		  }

		// Check username exists
		public function check_userid_exists($user_id){
			$query = $this->db->get_where('tb_user', array('user_id' => $user_id));
			if(empty($query->row_array())){
				return false; // true;
			} else {
				return true; // false;
			}
		}

		// Check email exists
		public function check_email_exists($user_email){
			$query = $this->db->get_where('tb_user', array('user_email' => $user_email));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}
	}