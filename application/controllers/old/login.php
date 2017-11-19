<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('mymodel','mm');
	}
	
	function index()
	{	
		$this->load->view('login');
	}
	
	function proses_login(){
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');

		if($this->form_validation->run() == FALSE){
			redirect('login','refresh');
		}else{
			
			$user = $this->input->post('username');
			$pass = md5($this->input->post('password'));

			$data = $this->mm->get_where_field('login','username',array('username'=>$user,'password'=>$pass));
			
			if($data->num_rows() > 0){

				$data = $data->row_array();
				
				$sess['log_admin'] 	= TRUE;
				$sess['username']   = $data['username'];

				$this->session->set_userdata($sess);

				redirect('dashboard','refresh');
				
			}
			else{
				redirect('login','refresh');
			}
			
		}
		
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect('login','refresh');
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */