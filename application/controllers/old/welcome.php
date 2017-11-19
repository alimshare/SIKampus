<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
		function __construct(){
			parent::__construct();

			$this->load->model('m_coba');
			$this->load->helper('form');
		}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function index()
	{
		$this->load->view('view_kontak');
	}

	public function kontak(){
		$this->load->view('view_kontak');
	}

	public function group(){
		$this->load->view('view_group');
	}

	public function respon(){
		$this->load->view('view_respon');
	}

	public function form() { 
		echo "Hello World";
		echo "<br>";
		echo base_url();
	}

	public function testrespon() {
		$data['username'] = $this->input->post('nim');
		$data['password'] = $this->input->post('nama');

		$nilai = array(
				'username'=>$data['username'],
				'password'=>$data['password']
			);

		$this->m_coba->simpan($nilai);
	}

	public function autonumber($tabel, $kolom, $lebar=0, $awalan=''){
		$last_rec 		= $this->m_coba->getLastRec($tabel, $kolom);
		$jumlahrecord 	= count($last_rec);
		if($jumlahrecord == 0)
			$nomor=1;
		else
		{
			$nomor	= intval(substr($last_rec->id_group,strlen($awalan)))+1;
		}
		if($lebar>0)
			$angka 	= $awalan.str_pad($nomor,$lebar,"0",STR_PAD_LEFT);
		else
			$angka 	= $awalan.$nomor;
		
		return $angka;
	}

	public function simpan_kontak() {
		$data['notelp'] = $this->input->post('notelp');
		$data['nama'] 	= $this->input->post('nama');
		$data['alamat'] = $this->input->post('alamat');

		$nilai = array(
				'no_hp'	=>$data['notelp'],
				'nama'	=>$data['nama'],
				'alamat'=>$data['alamat']
			);

		$this->m_coba->simpan('kontak',$nilai);
		redirect('welcome/kontak');
	}

	public function simpan_group() {
		$data['id_group'] 	= $this->autonumber('grup','id_group',5,'G');
		$data['nama_group'] = $this->input->post('nama');
		$data['deskripsi'] 	= $this->input->post('deskripsi');

		$nilai = array(
				'id_group'	=>$data['id_group'],
				'nama_group'=>$data['nama_group'],
				'deskripsi'	=>$data['deskripsi']
			);

		$this->m_coba->simpan('grup',$nilai);
		redirect('welcome/group');
	}

	public function simpan_respon() {
		$data['keyword'] 		= $this->input->post('keyword');
		$data['respon_balasan'] = $this->input->post('respon');

		$nilai = array(
				'keyword'		=>$data['keyword'],
				'respon_balasan'=>$data['respon_balasan']
			);

		$this->m_coba->simpan('respon',$nilai);
		redirect('welcome/respon');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */