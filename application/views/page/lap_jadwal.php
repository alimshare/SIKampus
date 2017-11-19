<?php 

	class PDF extends FPDF
	{
		//Page header
		function Header()
		{	                
	                $this->Ln(12);
	                $this->setFont('Arial','',12);
	                $this->setFillColor(255,255,255);
	                $this->cell(100,6,'Jadwal Perkuliahan STMIK Mahakarya',0,1,'L',1); 
	                $this->setFont('Arial','',10);	
	                $this->cell(100,6,"Tanggal Cetak : ".date('d M Y'),0,1,'L',1); 
	                
	                
	                $this->Ln(5);
	                $this->setFont('Arial','',10);
	                $this->setFillColor(230,230,200);
	                $this->cell(10,6,'No.',1,0,'C',1);
	                $this->cell(30,6,'Hari',1,0,'C',1);
	                $this->cell(30,6,'Waktu',1,0,'C',1);
	                $this->cell(70,6,'Mata Kuliah',1,0,'C',1);
	                $this->cell(70,6,'Dosen',1,0,'C',1);
	                $this->cell(30,6,'Ruang',1,0,'C',1);
	                $this->cell(30,6,'Gedung',1,0,'C',1);
	                
		}
	 
		function Content($data)
		{
	            // $ya = 46;
	            // $rw = 6;
	            $no = 1;
	            foreach ($data as $key => $val) {
	                		$this->Ln();
	                        $this->setFont('Arial','',10);
	                        $this->setFillColor(255,255,255);	

	                        $this->cell(10,10,$no,1,0,'C',1);
	                		$this->cell(30,10,$val['nama_hari'],1,0,'C',1);
			                $this->cell(30,10,substr($val['jam_awal'],0,5) ,1,0,'C',1);
			                $this->cell(70,10,$val['nama_mata_kuliah'],1,0,'L',1);
			                $this->cell(70,10,$val['nama_dosen'],1,0,'L',1);
			                $this->cell(30,10,$val['nama_ruang'],1,0,'C',1);
			                $this->cell(30,10,$val['gedung'],1,0,'C',1);
	                        $no++;
	                }            
	 
		}
		function Footer()
		{
			//atur posisi 1.5 cm dari bawah
			$this->SetY(-15);
			//buat garis horizontal
			$this->Line(10,$this->GetY(),285,$this->GetY());
			//Arial italic 9
			$this->SetFont('Arial','I',9);
	                $this->Cell(0,10,'STMIK Mahakarya ',0,0,'L');
			//nomor halaman
			$this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
		}
	}

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage('L');

	$pdf->Content($data);

	$pdf->Output();
?>