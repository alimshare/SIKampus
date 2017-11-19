<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mahasiswa extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('mymodel');
		$this->auth();
	}

	function auth(){
		if (!$this->session->userdata('log_admin')){
			redirect('login');
		}
	}

	public function index()
	{
		$data['content'] 	= 'page/mahasiswa/mahasiswa_list';
		$data['record']		= $this->mymodel->get_where_field('mahasiswa','nim,nama',array('visible'=>'1'))->result_array();

		$this->load->view('template',$data);
	}

	public function view($id)
	{
		$data['content'] 	= 'page/mahasiswa/mahasiswa_view';
		$data['record']		= $this->mymodel->get_where('mahasiswa',array('nim'=>$id))->row_array();

		$this->load->view('template',$data);
	}

	public function form()
	{
		$data['content'] 	= 'page/mahasiswa/mahasiswa_form';

		$this->load->view('template',$data);
	}

	public function edit($id)
	{
		$data['content'] 	= 'page/mahasiswa/mahasiswa_form_edit';
		$data['record']		= $this->mymodel->get_where('mahasiswa',array('nim'=>$id))->row_array();

		$this->load->view('template',$data);
	}

	function save(){
		$data['nim'] 		= $this->input->post('nim');
		$data['nama'] 		= $this->input->post('nama');
		$data['no_telp'] 	= $this->input->post('telp');
		$data['email ']		= $this->input->post('email');

		$stat = $this->mymodel->insert('mahasiswa',$data);
		if ($stat){
			$this->session->set_flashdata('message.body','Mahasiswa berhasil disimpan !');
			redirect('mahasiswa');
		} else {
			echo "Gagal ". mysql_error();
		}
	}

	function update(){
		$nim	 			= $this->input->post('nim');

		$data['nama'] 		= $this->input->post('nama');
		$data['no_telp'] 	= $this->input->post('telp');
		$data['email ']		= $this->input->post('email');

		$stat = $this->mymodel->update('mahasiswa',$data,array('nim'=>$nim));
		if ($stat){
			$this->session->set_flashdata('message.body','Mahasiswa berhasil diubah !');
			redirect('mahasiswa/edit/'.$nim);
		} else {
			echo "Gagal ". mysql_error();
		}
	}

	function delete($id){		
		$nilai['nim'] = $id;

		$stat = $this->mymodel->delete('mahasiswa',$nilai);
		if ($stat){
			$this->session->set_flashdata('message.body','Mahasiswa berhasil dihapus !');
			redirect('mahasiswa');
		} else {
			echo "Gagal ". mysql_error();
		}

	}

	public function exportExcel()
	{
		//load our new PHPExcel library
		$this->load->library('excel');
		$parameter['data'] 	= $this->mymodel->get_where_field('mahasiswa','nim,nama,no_telp,email',
								array('visible' => '1'),'nim')->result_array();
		
		$this->load->view('page/mahasiswa/mahasiswa_export', $parameter);
	}

}

/* End of file mahasiswa.php */
/* Location: ./application/controllers/mahasiswa.php */
