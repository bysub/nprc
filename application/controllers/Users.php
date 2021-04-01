<?php
	class Users extends CI_Controller{
		// Register user
		public function register(){
			$data['title'] = 'Sign Up';

			$this->form_validation->set_rules('user_id', 'ID', 'trim|required|check_userid_exists' ,array('check_userid_exists' => 'That `ID` is taken. Please choose a different one'));
			$this->form_validation->set_rules('user_nm', 'Name', 'required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('password2', 'Confirm Password', 'trim|matches[password]');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/register', $data);
				$this->load->view('templates/footer');
			} else {
				$user_id = $this->input->post('user_id');
				// Encrypt password
				$enc_password = md5($this->input->post('password'));
				/*
				if(!$this->check_userid_exists($user_id)){
					$this->form_validation->set_message('check_userid_exists', 'That username is taken. Please choose a different one');
					return false;
				}
				*/

				$this->user_model->register($enc_password);

				// Set message
				$this->session->set_flashdata('user_registered', 'You are now registered and can log in');

				// 
				
				// Login user
				$userInfo = $this->user_model->login($this->input->post('user_id'), $enc_password);

				if($userInfo['user_id']){
					// Create session
					$user_data = array(
						'user_id' => $userInfo['user_id'],
						'user_nm' => $userInfo['user_nm'],
						'user_auth' => $userInfo['user_auth'],
						'logged_in' => true
					);

					$this->session->set_userdata($user_data);

					// Set message
					$this->session->set_flashdata('user_loggedin', 'You are now logged in');

					redirect('home');
				} else {
					redirect('users/login');
				}

			}
		}

		// Log in user
		public function login(){
			$data['title'] = 'Sign In';

			$this->form_validation->set_rules('user_id', 'user_id', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header');
				$this->load->view('users/login', $data);
				$this->load->view('templates/footer');
			} else {
				
				// Get username
				$user_id = $this->input->post('user_id');
				// Get and encrypt the password
				$password = md5($this->input->post('password'));

				// Login user
				$userInfo = $this->user_model->login($user_id, $password);
				
				if($userInfo['user_id']){
					// Create session
					$user_data = array(
						'user_id' => $userInfo['user_id'],
						'user_nm' => $userInfo['user_nm'],
						'user_auth' => $userInfo['user_auth'],
						'logged_in' => true
					);
					$this->session->set_userdata($user_data);

					// Set message
					$this->session->set_flashdata('user_loggedin', 'You are now logged in');

					redirect('home');
				} else {
					// Set message
					$this->session->set_flashdata('login_failed', 'Login is invalid');

					redirect('users/login');
				}		
			}
		}

		// Log user out
		public function logout(){
			// Unset user data
			$this->session->unset_userdata('logged_in');
			$this->session->unset_userdata('user_id');
			$this->session->unset_userdata('user_nm');

			// Set message
			$this->session->set_flashdata('user_loggedout', 'You are now logged out');

			redirect('users/login');
		}

		// Check if username exists
		public function check_userid_exists($username){
			$this->form_validation->set_message('check_userid_exists', 'That username is taken. Please choose a different one');
			
			if($this->user_model->check_userid_exists($username)){
				return true;
			} else {
				return false;
			}
		}

		// Check if email exists
		public function check_email_exists($email){
			$this->form_validation->set_message('check_email_exists', 'That email is taken. Please choose a different one');
			if($this->user_model->check_email_exists($email)){
				return true;
			} else {
				return false;
			}
		}
	}