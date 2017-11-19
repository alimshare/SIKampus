<?php 
  function get_hari($id){
    
    switch ($id) {
      case '0':
        $hari = "Senin";
        break;
      case '1':
        $hari = "Selasa";
        break;
      case '2':
        $hari = "Rabu";
        break;
      case '3':
        $hari = "Kamis";
        break;
      case '4':
        $hari = "Jum'at";
        break;
      
      default:
        $hari = "";
        break;
    }

    return $hari;
  } 

		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);

		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Jadwal');

		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', 'Jadwal Kuliah STMIK MAHAKARYA');

		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);

		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

		//merge cell A1 until D1
		$this->excel->getActiveSheet()->mergeCells('A1:G1');

		//set aligment to center for that merged cell (A1 to D1)
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$filename='jadwal.xls'; //save our workbook as this file name

		# Header Data
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, "No"); 
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "Hari");
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, 3, "Waktu");
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "Mata Kuliah");
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, 3, "Dosen");
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, 3, "Ruang");
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, 3, "Gedung");

		$header_range = 'A3:G3';
		$this->excel->getActiveSheet()->getStyle($header_range)
			->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff00');

		# Content Data
		$row = 4;
		$no = 1;
		foreach ($data as $key => $value) {
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $no); 
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $value['nama_hari']); 
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, substr($value['jam_awal'],0,5)); 
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $value['nama_mata_kuliah']); 
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $value['nama_dosen']); 
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $value['nama_ruang']); 
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $value['gedung']); 

			$no++;
			$row++;
		}

		# set Column Width
		for ($col = ord('a'); $col <= ord('g'); $col++)
		{
		    $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		}

		//Add  New worksheet 
		$ews2 = new \PHPExcel_Worksheet($this->excel, 'Denah Jadwal');
		$this->excel->addSheet($ews2, 1);

		//name the worksheet
		$ews2->setTitle('Denah Jadwal');

		//set cell A1 content with some text
		$ews2->setCellValue('A1', 'Denah Jadwal');

		//change the font size
		$ews2->getStyle('A1')->getFont()->setSize(18);

		//make the font become bold
		$ews2->getStyle('A1')->getFont()->setBold(true);
		
		$row = 3;
		foreach ($jadwal as $k_jadwal_perhari => $jadwal_perhari){

			$ews2->setCellValueByColumnAndRow(0, $row, get_hari($k_jadwal_perhari));
			$header_range = 'A'.$row.':H'.$row;
			$ews2->getStyle('A'.$row)->getFont()->setSize(14);
			$ews2->getStyle($header_range)
				->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00ffff00');
			$this->excel->getActiveSheet()->mergeCells($header_range);			
			$ews2->getStyle($header_range)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$row++;

        	$col = 1; $col_code = ord('b');      	
		    foreach ($ruang as $k_ruang => $v_ruang) { 
                $displayText = 	$v_ruang['nama_ruang'];
				$ews2->setCellValueByColumnAndRow($col, $row, $displayText); 

				$cell = chr($col_code).$row;
				$ews2->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $col++;$col_code++;
            }
            $row++;

	        foreach ($jadwal_perhari as $k_jadwal_persesi => $jadwal_persesi){


				$waktu = substr($sesi[$k_jadwal_persesi]['jam_awal'],0,5) . " - " . substr($sesi[$k_jadwal_persesi]['jam_akhir'],0,5);
				$ews2->setCellValueByColumnAndRow(0, $row, $waktu);
				$ews2->getStyle('A'.$row)->getAlignment()->setWrapText(true);	 
				$ews2->getStyle('A'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	        	$col = 1; $col_code = ord('b');        	
			    foreach ($jadwal_persesi as $k_jadwal_perruang => $jadwal_perruang) { 
                    $displayText = 	$jadwal_perruang['nama_mata_kuliah'] ."\n". 
                    				$jadwal_perruang['nama_dosen'] ."\n". 
                    				$jadwal_perruang['kelp'];

					$ews2->setCellValueByColumnAndRow($col, $row, $displayText);

					$cell = chr($col_code).$row;
	        		
	        		$ews2->getColumnDimension(chr($col_code))->setWidth(20);
					$ews2->getStyle($cell)->getAlignment()->setWrapText(true);	 
					$ews2->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    
                    $col++;$col_code++;
	            }

	            $row++;
			}
			$row++;
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