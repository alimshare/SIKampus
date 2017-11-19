<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dosen extends CI_Controller {

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
		$data['content'] 	= 'page/dosen/dosen_list';
		$data['record']		= $this->mymodel->get_where_field('dosen','id_dosen,nama_dosen',array('id_dosen <>'=>'1', 'visible'=>1))->result_array();

		$this->load->view('template',$data);
	}

	public function view($id)
	{
		$data['content'] 	= 'page/dosen/dosen_view';
		$data['record']		= $this->mymodel->get_where('dosen',array('id_dosen'=>$id))->row_array();
		$this->load->view('template',$data);
	}

	public function form()
	{
		$data['content'] 	= 'page/dosen/dosen_form';
		$this->load->view('template',$data);
	}

	public function edit($id)
	{
		$data['content'] 	= 'page/dosen/dosen_form_edit';
		$data['record']		= $this->mymodel->get_where('dosen',array('id_dosen'=>$id))->row_array();

		$this->load->view('template',$data);
	}

	public function jadwal($id)
	{
		$data['content'] 	= 'page/dosen/dosen_jadwal';
		$data['record']		= $this->mymodel->get_where('dosen',array('id_dosen'=>$id))->row_array();
		$this->load->view('template',$data);
	}

	function save(){
		$data['nama_dosen'] 	= $this->input->post('nama_dosen');
		$data['no_telp'] 		= $this->input->post('nomor_dosen');
		$data['email ']			= $this->input->post('email_dosen');

		$stat = $this->mymodel->insert('dosen',$data);
		if ($stat){
			$this->session->set_flashdata('message.body','Dosen berhasil disimpan !');
			redirect('dosen');
		} else {
			echo "Gagal ". mysql_error();
		}
	}

	function update(){

		$id_dosen	 			= $this->input->post('id_dosen');

		$data['nama_dosen'] 	= $this->input->post('nama_dosen');
		$data['no_telp'] 		= $this->input->post('nomor_dosen');
		$data['email ']			= $this->input->post('email_dosen');

		$stat = $this->mymodel->update('dosen',$data,array('id_dosen'=>$id_dosen));
		if ($stat){
			$this->session->set_flashdata('message.body','Dosen berhasil diubah !');
			redirect('dosen/edit/'.$id_dosen);
		} else {
			echo "Gagal ". mysql_error();
		}
	}

	function delete($id){		
		
		$nilai = array (
			'id_dosen' => $id			
		);

		$stat = $this->mymodel->delete('dosen',$nilai);
		if ($stat){
			$this->session->set_flashdata('message.body','Dosen berhasil dihapus !');
			redirect('dosen');
		} else {
			echo "Gagal ". mysql_error();
		}

	}

	public function exportExcel()
	{
		//load our new PHPExcel library
		$this->load->library('excel');
		$parameter['data'] 	= $this->mymodel->get_where_field('dosen','nama_dosen,no_telp,email',
								array('visible' => '1', 'nama_dosen <>'=> ""),'nama_dosen')->result_array();
		
		$this->load->view('page/dosen/dosen_export', $parameter);
	}

}

/* End of file dosen.php */
/* Location: ./application/controllers/dosen.php */
