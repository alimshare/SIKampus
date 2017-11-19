<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('mymodel','mm');

		$this->load->library('grocery_CRUD');
	}

	public function display($output = null)
	{
		$this->load->view('template',$output);
	}
	
	function index()
	{	
		$string = $this->home();

		$this->display((object)array('output' => $string , 'js_files' => array() , 'css_files' => array()));
	}

	function home(){
		$string = "			
			<p>
				<strong>Selamat Datang</strong>
				<br>
				<br>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				<br>
				<br>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</p>
		";

		return $string;
	}

	function dosen(){

		$crud = new grocery_CRUD();

		$crud->set_subject('Dosen');
		#$crud->set_theme('twitter-bootstrap');
		$crud->set_table('dosen');
		$output = $crud->render();

		$this->display($output);
	}

	function matkul(){

		$crud = new grocery_CRUD();

		$crud->set_subject('Mata Kuliah');
		#$crud->set_theme('datatables');
		$crud->set_table('mata_kuliah');
		$output = $crud->render();

		$this->display($output);
	}

	function tahun_ajaran(){

		$crud = new grocery_CRUD();

		$crud->set_subject('Tahun Ajaran');
		#$crud->set_theme('datatables');
		$crud->set_table('tahun_ajaran');
		$output = $crud->render();

		$this->display($output);
	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */