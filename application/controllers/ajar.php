<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ajar extends CI_Controller {

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
		$data['content'] 	= 'page/ajar/ajar_list';
		$data['record']		= $this->mymodel->get_where('view_ajar',
			array(
				'nama_dosen <>'=>'',
				'id_tahun_ajaran'=>$this->session->userdata('id_tahun_ajaran')
			)
		)->result_array();

		$this->load->view('template',$data);
	}

	public function view($id, $flagCancel='0')
	{
		$data['content'] 			= 'page/ajar/ajar_view';

		$data['record']				= $this->mymodel->get_where('view_all',array('id_ajar'=>$id))->row_array();
		$data['data_peserta']		= $this->mymodel->get_where_field('view_jadwal_mahasiswa','nim,nama',array('id_ajar'=>$id))->result_array();

		if ($flagCancel == 1) $data['url_cancel'] = base_url('dashboard/fjadwal');

		$this->load->view('template',$data);
	}

	public function form()
	{
		$data['content'] 			= 'page/ajar/ajar_form';
		$data['data_dosen'] 		= $this->mymodel->get_field('dosen','id_dosen,nama_dosen')->result_array();
		$data['data_mata_kuliah'] 	= $this->mymodel->get_field('mata_kuliah','id_mata_kuliah,nama_mata_kuliah')->result_array();
		$data['data_ta'] 			= $this->mymodel->get_where('tahun_ajaran',array('status'=>'1'))->result_array();
		$this->load->view('template',$data);
	}

	public function edit($id)
	{
		$data['content'] 			= 'page/ajar/ajar_form_edit';
		$data['data_dosen'] 		= $this->mymodel->get_field('dosen','id_dosen,nama_dosen')->result_array();
		$data['data_mata_kuliah'] 	= $this->mymodel->get_field('mata_kuliah','id_mata_kuliah,nama_mata_kuliah')->result_array();
		$data['data_ta'] 			= $this->mymodel->get_where('tahun_ajaran',array('status'=>'1'))->result_array();

		$data['record']				= $this->mymodel->get_where('ajar',array('id_ajar'=>$id))->row_array();

		$this->load->view('template',$data);
	}

	function save()
	{
		$data['id_mata_kuliah'] 	= $this->input->post('id_mata_kuliah');
		$data['id_dosen'] 			= $this->input->post('id_dosen');
		$data['id_tahun_ajaran'] 	= $this->input->post('id_tahun_ajaran');
		$data['kelp'] 				= $this->input->post('kelp');

		if ($this->mymodel->cek_data("jadwal_kuliah",array('id_tahun_ajaran'=>$data['id_tahun_ajaran']))){	
			$this->session->set_flashdata('tipeMessage','danger');
			$this->session->set_flashdata('message','Data Ajar Tidak bisa <ins>ditambahkan</ins> dan <ins>dihapus</ins> ketika Jadwal Kuliah di Semester Aktif sudah dibuat !');
			redirect('ajar');			
		} else {
			# Delete semua data ajar yang ada dengan id_dosen = 1
			$nilai = array (
				'id_dosen' => '1'			
			);
			$stat = $this->mymodel->delete('ajar',$nilai);
			
			$stat = $this->mymodel->insert('ajar',$data);
			if ($stat){
				$this->session->set_flashdata('message','Data Ajar berhasil disimpan !');
				redirect('ajar');
			} else {
				echo "Gagal ". mysql_error();
			}
		}
	}

	function update()
	{	
		$id_ajar 					= $this->input->post('id_ajar');

		$data['id_mata_kuliah'] 	= $this->input->post('id_mata_kuliah');
		$data['id_dosen'] 			= $this->input->post('id_dosen');
		$data['id_tahun_ajaran'] 	= $this->input->post('id_tahun_ajaran');
		$data['kelp'] 				= $this->input->post('kelp');

		$stat = $this->mymodel->update('ajar',$data,array('id_ajar'=>$id_ajar));
		if ($stat){
			$this->session->set_flashdata('message','Data Ajar berhasil diubah !');
			redirect('ajar');
		} else {
			echo "Gagal ". mysql_error();
		}
	}

	function delete($id)
	{
		$tahun_ajaran 			= $this->session->userdata('id_tahun_ajaran'); 
		$nilai = array (
			'id_ajar' => $id			
		);

		if ($this->mymodel->cek_data("jadwal_kuliah",array('id_tahun_ajaran'=>$tahun_ajaran))){	
			$this->session->set_flashdata('tipeMessage','danger');
			$this->session->set_flashdata('message','Data Ajar Tidak bisa <ins>ditambahkan</ins> dan <ins>dihapus</ins> ketika Jadwal Kuliah di Semester Aktif sudah dibuat !');
			redirect('ajar');			
		} else {
			$stat = $this->mymodel->delete('ajar',$nilai);
			if ($stat){
				$this->session->set_flashdata('message','Data Ajar berhasil dihapus !');
				redirect('ajar');
			} else {
				echo "Gagal ". mysql_error();
			}
		}
	}

	public function exportExcel($id=0)
	{
		//load our new PHPExcel library
		$this->load->library('excel');
		$parameter['header']	= $this->mymodel->get_where('view_all',array('id_ajar'=>$id))->row_array();
		$parameter['data']		= $this->mymodel->get_where_field('view_jadwal_mahasiswa','nim,nama',array('id_ajar'=>$id))->result_array();

		
		$this->load->view('page/ajar/ajar_export', $parameter);
	}

}

/* End of file ajar.php */
/* Location: ./application/controllers/ajar.php */
