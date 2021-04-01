<?php
	class Overview extends CI_Controller{
		public function view($page = FALSE){
			// $this->load->model(array("common_model"));
			if(empty($page)) {
				$page = 'agm';
			}

			$this->load->view('templates/header');
            $this->load->view('overview/'.$page);
			$this->load->view('templates/footer');
		}
	}
?>