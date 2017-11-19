<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ebook extends CI_Controller {
	
	function __construct(){
		parent::__construct();

		$this->load->model('ebook_model');
		$this->load->helper('form');
	}
	
	public function index()
	{
		#$data['data'] = $this->mymodel->all('jabatan')->result_array();
		#$this->load->view('data_jabatan',$data);
	}

	public function login() {
		$this->load->view('login');
	}

	public function auth() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$data 		= $this->ebook_model->get_user($username, $password);
		if ($data->num_rows() == 0) redirect('ebook/login');

	}
	
	public function form()
	{
		$data['lab']		= $this->mymodel->all('lab')->result_array();
		$data['asisten']	= $this->mymodel->all('asisten')->result_array();		
		$this->load->view('view_jabatan_form',$data);
	}

	#public function form_edit($id_lab,$nim) {
	#	$data['data'] = $this->mymodel->get_where('jabatan',array('id_hardware'=>$id_hardware))->row_array();
	#	$this->load->view('view_hardware_form_edit',$data);
	#}

	public function simpan() {
		$data['nim'] 		= $this->input->post('nim');
		$data['id_lab'] 	= $this->input->post('id_lab');
		$data['level'] 		= $this->input->post('level');

		$nilai = array(
				'id_lab'	=>$data['id_lab'],
				'nim'		=>$data['nim'],
				'level'		=>$data['level']
			);

		$this->mymodel->insert('jabatan',$nilai);
		redirect('jabatan');
	}	

	public function hapus($id_lab,$nim) {
		
		$nilai = array (
			'id_lab' 	=> $id_lab,			
			'nim' 		=> $nim			
		);

		$this->mymodel->delete('jabatan',$nilai);
		redirect('jabatan');
	}

	public function edit() {
		$data['id_lab']	= $this->input->post('id_lab');
		$data['nim']	= $this->input->post('nim');
		$data['level']	= $this->input->post('level');

		$nilai = array(
					'id_lab' 	=> $data['id_lab'], 
					'nim' 		=> $data['nim'], 
					'level' 	=> $data['level'] 
		);

		$this->mymodel->update('jabatan',$nilai,array('id_lab'=>$data['id_lab'],'nim'=>$data['nim']));
		redirect('jabatan');
	}

	public function autonumber($tabel, $kolom, $lebar=0, $awalan=''){
		$last_rec 		= $this->mymodel->get_last_record($tabel, $kolom);
		$jumlahrecord 	= count($last_rec);
		if($jumlahrecord == 0)
			$nomor=1;
		else
		{
			$nomor	= intval(substr($last_rec->$kolom,strlen($awalan)))+1;
		}
		if($lebar>0)
			$angka 	= $awalan.str_pad($nomor,$lebar,"0",STR_PAD_LEFT);
		else
			$angka 	= $awalan.$nomor;
		
		return $angka;
	}

}

/* End of file hardware.php */
/* Location: ./application/controllers/hardware.php */