<?php
	class Fastq extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->helper("file");
            $this->load->helper('download');
            $this->load->helper("security");
        }
        
		public function index(){    
			$this->load->view('templates/header');            
			$this->load->view('fastq/view');
			$this->load->view('templates/footer');
		}
        
        function download(){
            $down = $this->input->get("filepath");
            $file = $this->input->get("filenm");
            $file = $this->input->get("filenm");

            if($this->session->userdata('logged_in')){
                $data = get_file_info('.'.$down);
                $fileSize = $data['size']; 

                $handle = @fopen('.'.$down, "rb");
                @header("Cache-Control: no-cache, must-revalidate"); 
                @header("Pragma: no-cache"); //keeps ie happy
                @header("Content-Disposition: attachment; filename= ".$file);
                @header("Content-Type: application/x-zip"); 
                @header("Content-Length: ".$fileSize);
                @header('Content-Transfer-Encoding: binary');
                @header('Expires:0');
                
                ob_end_clean();//required here or large files will not work
                @fpassthru($handle);//works fine now
            } else {
                // Set message
                echo "<script>alert(\"Download is possible only when a member is connected.\");</script>";
            }
        }
    }
?>