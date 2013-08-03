<?php

 /**
 * This class creates the text file for reporting tax 606
 * @author Victor Rincon
 * @copyright	Copyright (c) 2012 - 2013, Pulsar Tecnologies, Inc.
 * @version 1.0
 */
 class Reporte606
 {

 	/**
 	* Function to generate the file
 	* @access public
 	* @param string  the name of file
 	* @param string  the rnc of the company
 	* @param date    the reporting date
 	* @param array   the expenditure records to be inserted into the file
 	* @param float   the total amount of all records 
 	* @return void
 	*/
 	public function generate($name="report_606", $rnc, $date, $item=array(), $total)
 	{
 		$comInfo = "606". $rnc . date_format($date, 'Ym') . $this->_space((string) count($item), 12) .  $this->_space((string) $total, 16);
 		$archivo = fopen($name . ".txt", "w") or die("El archivo no se pudo crear");
 		fwrite($archivo, $comInfo. "\r\n");

 		for ($i=0; $i < count($item); $i++) {
 			$rnc = str_pad(trim($item[$i][0]), 11);
 			$typeServiVoucher = trim($item[$i][1]) . trim($item[$i][2]) . trim($item[$i][3]);
 			$validDate = date_format(date_create($item[$i][4]), 'Ymd');
 			$paymentDate = date_format(date_create($item[$i][5]), 'Ymd');
 			$itbs = $this->_space((string) $item[$i][6], 12);
 			$retention = $this->_space((string) $item[$i][7], 12);
 			$amount = $this->_space((string) $item[$i][8], 12);
 			$realEstate = $this->_space((string) $item[$i][9], 12);
 			$body = $rnc .  str_pad($typeServiVoucher, 41) . $validDate . $paymentDate . $itbs . $retention . $amount . $realEstate;
 			fwrite($archivo, $body . "\r\n");
 		}

 		fclose($archivo);
        
 	}

 	/**
	* Function to fill in the missing zeros
	* @access private
	* @param string  string texto
	* @param integer quantity space
	* @return string
 	*/
 	private function _space($string, $quantity)
 	{
 		return str_pad(trim($string), $quantity, "0",  STR_PAD_LEFT);
 	}

 	private function rnc_validate($rnc){
 		if (strlen($rnc) == 9 || strlen($rnc) == 11)
 			return true;
 		else
 			return false;
 	}

 	private function type_validate($type)
 	{
 		if (is_numeric($type)) {
 			if ((int) $type > 0 && (int) $typy < 3) 
 				return true;
 			else
 				return false
 		}
 		else{
 			return false
 		}
 	}
 }

/*
* Example
* $value = array(
* 	array("124029902", 1, "09",  "A010040580100001856", "2012-12-04", "2012-12-04", "170.56", "0.00", "1066.15", "0.00"),
* 	array("124029902", 1, "09",  "A010040580100001856", "2012-12-04", "2012-12-04", "170.56", "0.00", "1066.15", "0.00"),
* 	array("124029902", 1, "09",  "A010040580100001856", "2012-12-04", "2012-12-04", "170.56", "0.00", "1066.15", "0.00"),
* 	array("124029902", 1, "09",  "A010040580100001856", "2012-12-04", "2012-12-04", "170.56", "0.00", "1066.15", "0.00"),
* );
* $report = new reporte606();
* $date = new DateTime("2012-12-01");
* $report->generate("reporteNuevo", "00106027899", $date, $value, 100);
**/
?>