<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class matkul extends CI_Controller {

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
		$data['content'] 	= 'page/matkul/matkul_list';
		$data['record']		= $this->mymodel->get_where_field('mata_kuliah','id_mata_kuliah,nama_mata_kuliah,sks',array('id_mata_kuliah <>'=>'1', 'visible'=>1))->result_array();

		$this->load->view('template',$data);
	}

	public function view($id)
	{
		$data['content'] 	= 'page/matkul/matkul_view';
		$data['record']		= $this->mymodel->get_where('mata_kuliah',array('id_mata_kuliah'=>$id))->row_array();

		$this->load->view('template',$data);
	}

	public function form()
	{
		$data['content'] 	= 'page/matkul/matkul_form';
		$this->load->view('template',$data);
	}

	public function edit($id)
	{
		$data['content'] 	= 'page/matkul/matkul_form_edit';
		$data['record']		= $this->mymodel->get_where('mata_kuliah',array('id_mata_kuliah'=>$id))->row_array();

		$this->load->view('template',$data);
	}

	function save()
	{
		$data['nama_mata_kuliah'] 	= $this->input->post('nama_mata_kuliah');
		$data['sks'] 				= $this->input->post('sks');

		$stat = $this->mymodel->insert('mata_kuliah',$data);
		if ($stat){
			$this->session->set_flashdata('message.body','Mata Kuliah berhasil disimpan !');
			redirect('matkul');
		} else {
			echo "Gagal ". mysql_error();
		}
	}

	function update()
	{	
		$id_mata_kuliah	 			= $this->input->post('id_mata_kuliah');

		$data['nama_mata_kuliah'] 	= $this->input->post('nama_mata_kuliah');
		$data['sks'] 				= $this->input->post('sks');

		$stat = $this->mymodel->update('mata_kuliah',$data,array('id_mata_kuliah'=>$id_mata_kuliah));
		if ($stat){
			$this->session->set_flashdata('message.body','Mata Kuliah berhasil diubah !');
			redirect('matkul/edit/'.$id_mata_kuliah);
		} else {
			echo "Gagal ". mysql_error();
		}
	}

	function delete($id)
	{		
		$nilai['id_mata_kuliah'] = $id;

		$stat = $this->mymodel->delete('mata_kuliah',$nilai);
		if ($stat){
			$this->session->set_flashdata('message.body','Mata Kuliah berhasil dihapus !');
			redirect('matkul');
		} else {
			echo "Gagal ". mysql_error();
		}
	}


	public function exportExcel()
	{
		//load our new PHPExcel library
		$this->load->library('excel');
		$parameter['data'] 	= $this->mymodel->get_where_field('mata_kuliah','nama_mata_kuliah,sks',
								array('visible' => '1', 'nama_mata_kuliah <>'=> ""),'nama_mata_kuliah')->result_array();
		
		$this->load->view('page/matkul/matkul_export', $parameter);
	}

}

/* End of file matkul.php */
/* Location: ./application/controllers/matkul.php */
