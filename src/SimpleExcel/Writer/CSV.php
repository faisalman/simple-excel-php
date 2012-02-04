<?php
/**
 * SimpleExcel class for writing CSV Spreadsheet
 *  
 * @author	Faisalman
 * @package	SimpleExcel
 */
class SimpleExcel_Writer_CSV implements SimpleExcel_Writer_Interface
{
	/**
	 * Holds data part of CSV
	 * 
	 * @access	private
	 * @var		string
	 */
	private $csv_data;
	
	/**
	 * Holds delimiter char
	 * 
	 * @access	private
	 * @var		string
	 */
	private $delimiter;
	
	/**
	 * @return	void
	 */
	public function __construct(){
	    $this->csv_data = array();
	    $this->delimiter = ',';
	}

	/**
	 * Adding row data to CSV
	 * 
	 * @param	array	$values An array contains ordered value for every cell
	 * @return	void
	 */
	public function addRow($values){
	    if(!is_array($values)){
	        $values = array($values);
	    }
        array_push($this->csv_data, $values);
	}

	/**
	 * Export the CSV document
	 * 
	 * @param	string	$filename	Name for the downloaded file (extension will be set automatically)
	 * @return	void
	 */
	public function saveFile($filename){
		
		// set HTTP response header
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename='.$filename.'.csv');

        // write CSV output to browser
		$fp = fopen('php://output', 'w');
		foreach($this->csv_data as $row){
            fputcsv($fp, $row, $this->delimiter);
        }
        fclose($fp);
		
		// since there must be no data below
		exit();
	}
	
	/**
	 * Set character for delimiter
	 * 
	 * @param	string	$delimiter  Commonly used character can be a comma, semicolon, tab, or space
	 * @return	void
	 */
	public function setDelimiter($delimiter){
	    $this->delimiter = $delimiter;
	}
}
?>
