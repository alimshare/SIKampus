<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('mymodel');
		#$this->load->helper('form');

		$this->auth();
	}

	public function index()
	{
		$this->auth();
		$data['content']	= 'page/home';
		$this->load->view('template', $data);
	}

	function auth(){
		if (!$this->session->userdata('log_admin')){
			redirect('login');
		}
	}

	############# =========== DOSEN ================== ############

	public function mdosen()
	{
		$data['content'] 	= 'page/list_dosen';
		$data['record']		= $this->mymodel->get_where_field('dosen','id_dosen,nama_dosen',array('id_dosen <>'=>'1'))->result_array();

		$this->load->view('template',$data);
	}

	public function fdosen()
	{
		$data['content'] 	= 'page/form_dosen';
		$this->load->view('template',$data);
	}

	public function fdosen_edit($id)
	{
		$data['content'] 	= 'page/form_dosen_edit';
		$data['record']		= $this->mymodel->get_where('dosen',array('id_dosen'=>$id))->row_array();

		$this->load->view('template',$data);
	}

	############# =========== MATA KULIAH ================== ############

	public function mmatkul()
	{
		$data['content'] 	= 'page/list_matkul';
		$data['record']		= $this->mymodel->get_where_field('mata_kuliah','id_mata_kuliah,nama_mata_kuliah,sks',array('id_mata_kuliah <>'=>'1'))->result_array();

		$this->load->view('template',$data);
	}

	public function fmatkul()
	{
		$data['content'] 	= 'page/form_matkul';
		$this->load->view('template',$data);
	}

	public function fmatkul_edit($id)
	{
		$data['content'] 	= 'page/form_matkul_edit';
		$data['record']		= $this->mymodel->get_where('mata_kuliah',array('id_mata_kuliah'=>$id))->row_array();

		$this->load->view('template',$data);
	}

	############# =========== TAHUN AJARAN ================== ############

	public function mta()
	{
		$data['content'] 	= 'page/list_ta';
		$data['record']		= $this->mymodel->get_field('tahun_ajaran','id_tahun_ajaran,tahun_ajar,semester,status')->result_array();

		$this->load->view('template',$data);
	}

	public function fta()
	{
		$data['content'] 	= 'page/form_ta';
		$this->load->view('template',$data);
	}

	public function fta_edit($id)
	{
		$data['content'] 	= 'page/form_ta_edit';
		$data['record']		= $this->mymodel->get_where('tahun_ajaran',array('id_tahun_ajaran'=>$id))->row_array();

		$this->load->view('template',$data);
	}

	############# =========== MENGAJAR ================== ############

	public function majar()
	{
		$data['content'] 	= 'page/list_ajar';
		$data['record']		= $this->mymodel->get_where('view_ajar',
			array(
				'nama_dosen <>'=>'',
				'id_tahun_ajaran'=>$this->session->userdata('id_tahun_ajaran')
			)
		)->result_array();

		$this->load->view('template',$data);
	}

	public function fajar()
	{
		$data['content'] 	= 'page/form_ajar';
		$data['data_dosen'] 		= $this->mymodel->get_field('dosen','id_dosen,nama_dosen')->result_array();
		$data['data_mata_kuliah'] 	= $this->mymodel->get_field('mata_kuliah','id_mata_kuliah,nama_mata_kuliah')->result_array();
		$data['data_ta'] 			= $this->mymodel->get_where('tahun_ajaran',array('status'=>'1'))->result_array();
		$this->load->view('template',$data);
	}

	public function fajar_edit($id)
	{
		$data['content'] 	= 'page/form_ajar_edit';
		$data['data_dosen'] 		= $this->mymodel->get_field('dosen','id_dosen,nama_dosen')->result_array();
		$data['data_mata_kuliah'] 	= $this->mymodel->get_field('mata_kuliah','id_mata_kuliah,nama_mata_kuliah')->result_array();
		$data['data_ta'] 			= $this->mymodel->get_where('tahun_ajaran',array('status'=>'1'))->result_array();

		$data['record']				= $this->mymodel->get_where('ajar',array('id_ajar'=>$id))->row_array();

		$this->load->view('template',$data);
	}

	############# =========== MENGAJAR ================== ############

	public function fjadwal()
	{
		$data['content'] 	= 'page/form_jadwal';

		$data['data_ta'] 	= $this->mymodel->get_where('tahun_ajaran',array('status'=>'1'))->result_array();

		$data['hari']  = $this->mymodel->get_field('hari','id_hari,nama_hari')->result_array();
		$data['sesi']  = $this->mymodel->get_field('sesi','id_sesi,jam_awal,jam_akhir')->result_array();
		$data['ruang'] = $this->mymodel->get_field('ruang','id_ruang,nama_ruang')->result_array();

		$tahun_ajaran 		= $this->session->userdata('id_tahun_ajaran');
		$jadwal 			= $this->mymodel->get_where('view_jadwal_kuliah',array('id_tahun_ajaran'=>$tahun_ajaran))->result_array();


		if ($this->mymodel->cek_data('jadwal_kuliah',array('id_tahun_ajaran'=>$tahun_ajaran))) {
			$data['jadwal']		= array_chunk($jadwal, count($jadwal)/count($data['hari']));
			foreach ($data['jadwal'] as $k_jadwal_perhari => $jadwal_perhari) {
				$data['jadwal'][$k_jadwal_perhari] = array_chunk($jadwal_perhari, count($data['jadwal'][$k_jadwal_perhari])/count($data['sesi']) );
			}
		} else {
			$data['jadwal']		= array();
		}

		$this->load->view('template',$data);
	}


	############# =========== KESEDIAAN ================== ############

	public function fkesediaan($id)
	{
		$tahun_ajaran 		= $this->session->userdata('id_tahun_ajaran');
		$data['content'] 	= 'page/form_kesediaan';
		$data['data_dosen']	= $this->mymodel->get_where('dosen',array('id_dosen'=>$id))->row_array();

		# Jika Data kesediaan Semester ini belum diinput
		if (!$this->mymodel->cek_data('kesediaan',array('id_dosen'=>$id,'id_tahun_ajaran'=>$tahun_ajaran))) {

			$data['mode'] = 'insert';
			$data['sesi'] = $this->mymodel->get_field_distinct('sesi','id_sesi,jam_awal,jam_akhir')->result_array();
			$data['hari'] = $this->mymodel->get_field_distinct('hari','id_hari,nama_hari')->result_array();

		# Jika Data kesediaan Semester Sudah Diinput
		} else {

			$data['mode'] = 'edit';
			$data['sesi'] = $this->mymodel->get_field_distinct('sesi','id_sesi,jam_awal,jam_akhir')->result_array();
			$data['hari'] = $this->mymodel->get_field_distinct('hari','id_hari,nama_hari')->result_array();

			# Ambil data Hari
			foreach ($data['sesi'] as $key => $value) {

				# Cek Data Kesediaan Dosen untuk setiap sesi yang ada
				foreach ($data['hari'] as $k => $v) {
					$array_data 	= array(
							'id_dosen' 			=> $id,
							'id_tahun_ajaran' 	=> $tahun_ajaran,
							'id_hari'			=> $v['id_hari'],
							'id_sesi'			=> $value['id_sesi']
						);
					#$data['sesi'][$key]['hari'][$k]['id_hari']    = $v['id_hari'];
					#$data['sesi'][$key]['hari'][$k]['nama_hari']  = $v['nama_hari'];
					$data['sesi'][$key]['hari'][$k]['status']      = ($this->mymodel->cek_data('kesediaan',$array_data))? '1' : '0';
				}
			}

		}

		$this->load->view('template',$data);
	}

	public function fkesediaan_edit($id)
	{
		$tahun_ajaran 		= $this->session->userdata('id_tahun_ajaran');
		$data['content'] 	= 'page/form_kesediaan_edit';
		$data['data_dosen']	= $this->mymodel->get_where('dosen',array('id_dosen'=>$id))->row_array();

		$data['sesi'] = $this->mymodel->get_field_distinct('sesi','id_sesi,jam_awal,jam_akhir')->result_array();
		$data['hari'] = $this->mymodel->get_field_distinct('hari','id_hari,nama_hari')->result_array();

		# Ambil data Hari
		foreach ($data['sesi'] as $key => $value) {

			# Cek Data Kesediaan Dosen untuk setiap sesi yang ada
			foreach ($data['hari'] as $k => $v) {
				$array_data 	= array(
						'id_dosen' 			=> $id,
						'id_tahun_ajaran' 	=> $tahun_ajaran,
						'id_hari'			=> $v['id_hari'],
						'id_sesi'			=> $value['id_sesi']
					);
				#$data['sesi'][$key]['hari'][$k]['id_hari']    = $v['id_hari'];
				#$data['sesi'][$key]['hari'][$k]['nama_hari']  = $v['nama_hari'];
				$data['sesi'][$key]['hari'][$k]['status']     = ($this->mymodel->cek_data('kesediaan',$array_data))? '1' : '0';
			}
		}

		$this->load->view('template',$data);
	}

	############# =========== LAPORAN ================== ############

	public function lapjadwal()
	{
        $this->load->library('fpdf');
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));

		$tahun_ajaran 		= $this->session->userdata('id_tahun_ajaran');
		$parameter['data'] = $this->mymodel->get_where_field('view_all',
								'nama_hari,jam_awal,jam_akhir,nama_mata_kuliah,nama_dosen,nama_ruang,gedung',
								array('id_tahun_ajaran'=>$tahun_ajaran, 'id_dosen <>' => '1'))->result_array();

		$this->load->view('page/lap_jadwal', $parameter);
	}

	public function exportExcel()
	{
		//load our new PHPExcel library
		$this->load->library('excel');

		# Jadwal Bentuk Table
		$tahun_ajaran 		= $this->session->userdata('id_tahun_ajaran');
		$parameter['data'] = $this->mymodel->get_where_field('view_all',
								'nama_hari,jam_awal,jam_akhir,nama_mata_kuliah,nama_dosen,nama_ruang,gedung',
								array('id_tahun_ajaran'=>$tahun_ajaran, 'id_dosen <>' => '1'))->result_array();

		# Denah Jadwal
		$parameter['data_ta'] 	= $this->mymodel->get_where('tahun_ajaran',array('status'=>'1'))->result_array();
		$parameter['hari']  = $this->mymodel->get_field('hari','id_hari,nama_hari')->result_array();
		$parameter['sesi']  = $this->mymodel->get_field('sesi','id_sesi,jam_awal,jam_akhir')->result_array();
		$parameter['ruang'] = $this->mymodel->get_field('ruang','id_ruang,nama_ruang')->result_array();
		$tahun_ajaran 		= $this->session->userdata('id_tahun_ajaran');
		$jadwal 			= $this->mymodel->get_where('view_jadwal_kuliah',array('id_tahun_ajaran'=>$tahun_ajaran))->result_array();
		if ($this->mymodel->cek_data('jadwal_kuliah',array('id_tahun_ajaran'=>'1'))) {
			$parameter['jadwal']		= array_chunk($jadwal, count($jadwal)/count($parameter['hari']));
			foreach ($parameter['jadwal'] as $k_jadwal_perhari => $jadwal_perhari) {
				$parameter['jadwal'][$k_jadwal_perhari] = array_chunk($jadwal_perhari, count($parameter['jadwal'][$k_jadwal_perhari])/count($parameter['sesi']) );
			}
		} else {
			$parameter['jadwal']		= array();
		}
		# Denah Jadwal -- END ----

		$this->load->view('page/exportExcel', $parameter);
	}

	############# =========== PENJADWALAN MANUAL ================== ############

	public function manual()
	{
		$parameter['content'] 	= 'page/penjadwalanManual';
		$tahun_ajaran 			= $this->session->userdata('id_tahun_ajaran');

		$hari  = $this->mymodel->get_field('hari','id_hari,nama_hari');
		$sesi  = $this->mymodel->get_field('sesi','id_sesi,jam_awal,jam_akhir');
		$ruang = $this->mymodel->get_field('ruang','id_ruang,nama_ruang');

		$parameter['data_hari']  = $hari->result_array();
		$parameter['data_sesi']  = $sesi->result_array();
		$parameter['data_ruang'] = $ruang->result_array();

		$SQL	= "SELECT view_ajar.* FROM ajar INNER JOIN view_ajar ON view_ajar.id_ajar = ajar.id_ajar WHERE ajar.id_tahun_ajaran='$tahun_ajaran'";
		$ajar	= $this->mymodel->query($SQL)->result_array();

		shuffle($ajar);

		$parameter['jadwal'] = array_chunk($ajar, count($ajar)/$hari->num_rows());
		foreach ($parameter['jadwal'] as $key => $value) {
			$parameter['jadwal'][$key] = array_chunk($parameter['jadwal'][$key], count($parameter['jadwal'][$key])/$sesi->num_rows());
		}

		$parameter['jadwalTersedia']= false;
		if ($this->mymodel->cek_data("jadwal_kuliah",array('id_tahun_ajaran'=>$tahun_ajaran))){
			$parameter['jadwalTersedia']= true;
		}

		$this->load->view('template',$parameter);
	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
