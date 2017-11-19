<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alumni extends CI_Controller {
	
	function __construct(){
		parent::__construct();

		$this->load->model('mymodel');
		$this->load->helper('form');
	}
	
	public function index()
	{
		$data['content']	= 'view_search';
		$this->load->view('start',$data);
	}
	
	public function form()
	{
		$data['content']	= 'view_form_alumni';
		$this->load->view('start',$data);
	}

	public function form_edit($nim) 
	{
		$data['data'] = $this->mymodel->get_where('alumni',array('nim'=>$nim))->row_array();
		$this->load->view('view_hardware_form_edit',$data);	
	}
	
	public function list_alumni_all()
	{
		$data['data'] 		= $this->mymodel->all('alumni')->result_array();
		$data['content']	= 'data_alumni_foto';
		$this->load->view('start',$data);
	}
	
	public function list_alumni_name()
	{
		$nama 				= $this->input->post('txtsearch');
		
		$data['data'] 		= $this->mymodel->get_where_like('alumni', 'nama', $nama)->result_array();
		$data['content']	= 'data_alumni_foto';
		$this->load->view('start',$data);
	}

	public function angkatan() 
	{
		$data['data'] = $this->mymodel->get_where_distinct('alumni','angkatan')->result_array()	;
		$data['content']	= 'view_angkatan';
		$this->load->view('start',$data);
	}

	public function list_alumni_angkatan($tahun) 
	{
		$parameter['angkatan'] 	= $tahun;

		$data['data'] 			= $this->mymodel->get_where('alumni', $parameter)->result_array()	;
		$data['content']		= 'data_alumni_foto';

		$this->load->view('start',$data);
	}

	public function simpan() 
	{		

		$data['nim'] 			= $this->input->post('txtnim');
		$data['nama'] 			= $this->input->post('txtnama');
		$data['email'] 		 	= $this->input->post('txtemail');
		$data['alamat'] 		= $this->input->post('txtalamat');
		$data['no_telp'] 		= $this->input->post('txtnotelp');
		$data['pekerjaan'] 		= $this->input->post('txtpekerjaan');
		$data['angkatan'] 		= $this->input->post('txtangkatan');

		$result = $this->mymodel->get_where('alumni',array('nim'=>$data['nim']));
		if ($result->num_rows() > 0){ 

			$msg['title'] 	= 'Data Sudah Ada';
			$msg['desc'] 	= 'Data Alumni dengan NIM : '.$data["nim"].' sudah ada di Database Kami';
			
			$this->load->view('notif', $msg);

		} else{


			$validextensions 	= array("jpeg", "jpg", "png","JPG");
			$temporary 			= explode(".", $_FILES["file"]["name"]);
			$file_extension 	= end($temporary);

			if (isset($_FILES['file'])) {

				$conf['upload_path']	=	'./assets/foto';
				$conf['allowed_types']	=	'jpeg|jpg|png';
				$conf['file_name']		=	$data['nim'];

				$this->load->library('upload',$conf);
				
					if($this->upload->do_upload('file')){
						
						$input['file']	=	str_replace(' ','-',$_FILES['file']['name']);
						$data['foto']	= $data['nim'].".".strtolower($file_extension);
						
					}else{
						echo $error    = $this->upload->display_errors();
					}

			} else {

				$data['foto'] 			= "profile.png";

			}

			$this->mymodel->insert('alumni',$data);

			redirect('alumni');
		
		}
		
	}	

	public function hapus($nim) 
	{
		
		$nilai = array (
			'nim' => $nim			
		);

		$this->mymodel->delete('alumni',$nilai);
		redirect('alumni');
	}

	public function edit() 
	{

		$nim		 			= $this->input->post('txtnim');

		$data['nama'] 			= $this->input->post('txtnama');
		$data['email'] 		 	= $this->input->post('txtemail');
		$data['alamat'] 		= $this->input->post('txtalamat');
		$data['no_telp'] 		= $this->input->post('txtnotelp');
		$data['pekerjaan'] 		= $this->input->post('txtpekerjaan');
		$data['angkatan'] 		= $this->input->post('txtangkatan');

		$this->mymodel->update('alumni',$data,array('nim'=>$data['nim']));
		redirect('alumni');
	}

	public function detail_alumni($nim) 
	{
		$data['data'] 		= $this->mymodel->get_where('alumni',array('nim'=>$nim))->row_array();
		$data['content']	= 'detail_alumni';
		$this->load->view('start',$data);
	}

	public function autonumber($tabel, $kolom, $lebar=0, $awalan='')
	{
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

	public function ajax_image()
	{
		if(isset($_FILES["file"]["type"]))
		{
			$validextensions = array("jpeg", "jpg", "png");
			$temporary = explode(".", $_FILES["file"]["name"]);
			$file_extension = end($temporary);
		
			if ((($_FILES["file"]["type"] == "image/png") || 
				($_FILES["file"]["type"] == "image/jpg") || 
				($_FILES["file"]["type"] == "image/jpeg")
			) && ($_FILES["file"]["size"] < 3000000)//Approx. 100kb files can be uploaded.
			&& in_array($file_extension, $validextensions)) {
				if ($_FILES["file"]["error"] > 0)
				{
					echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
				}
				else
				{
					if (file_exists("upload/" . $_FILES["file"]["name"])) 
					{
						echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
					}
					else
					{
						$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
						$targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored
						move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
						echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
						echo "<br/><b>File Name:</b> " . $_FILES["file"]["name"] . "<br>";
						echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
						echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
						echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";
					}
				}
			}
			else
			{
			echo "<span id='invalid'>***Invalid file Size or Type***<span>";
			}
		}
	}

}

/* End of file alumni.php */
/* Location: ./application/controllers/alumni.php */