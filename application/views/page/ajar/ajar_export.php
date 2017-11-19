<?php 
	//activate worksheet number 1
	$this->excel->setActiveSheetIndex(0);

	//name the worksheet
	$this->excel->getActiveSheet()->setTitle('Daftar Peserta');

	//set cell A1 content with some text
	$this->excel->getActiveSheet()->setCellValue('A1', 'Daftar Peserta');

	//change the font size
	$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);

	//make the font become bold
	$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

	//merge cell A1 until D1
	$this->excel->getActiveSheet()->mergeCells('A1:B1');

	//set aligment to center for that merged cell (A1 to D1)
	$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$filename='daftar_peserta.xls'; //save our workbook as this file name

	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "TAHUN AJARAN"); 
	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, 3, $header['tahun_ajar']." ".strtoupper($header['semester'])); 

	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 4, "MATA KULIAH"); 
	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, 4, $header['nama_mata_kuliah']); 

	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 5, "DOSEN"); 
	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, 5, $header['nama_dosen']); 

	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 6, "KELP"); 
	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, 6, $header['kelp']); 

	# Header Data
	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 8, "NIM"); 
	$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, 8, "Nama");

	$header_range = 'A8:B8';
	$this->excel->getActiveSheet()->getStyle($header_range)
		->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('a8b5da');

	# Content Data
	$row = 9;
	$no = 1;
	foreach ($data as $key => $value) {
		$this->excel->getActiveSheet()->setCellValueExplicitByColumnAndRow(0, $row, $value['nim']); 
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value['nama']); 

		$no++;
		$row++;
	}

	# set Column Width
	for ($col = ord('a'); $col <= ord('g'); $col++)
	{
	    $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
	}


	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
	            
	//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
	//if you want to save it as .XLSX Excel 2007 format
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
	//force user to download the Excel file without writing it to server's HD
	$objWriter->save('php://output');

?>