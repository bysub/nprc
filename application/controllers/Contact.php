<?php
	class Contact extends CI_Controller{
		public function index(){
			// $this->load->model(array("common_model"));
			// $data['title'] = ucfirst($page);
			$this->load->view('templates/header');            
			$this->load->view('contact/view');
			$this->load->view('templates/footer');
		}
	}