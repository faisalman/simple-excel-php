<?php

namespace SimpleExcel\Writer;

/**
 * SimpleExcel class for writing CSV Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class CSVWriter implements IWriter
{
    /**
     * Holds data part of CSV
     * 
     * @access  private
     * @var     string
     */
    private $csv_data;

    /**
     * Holds delimiter char
     * 
     * @access  private
     * @var     string
     */
    private $delimiter;

    /**
     * @return  void
     */
    public function __construct(){
        $this->csv_data = array();
        $this->delimiter = ',';
    }

    /**
     * Adding row data to CSV
     * 
     * @param   array   $values An array contains ordered value for every cell
     * @return  void
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
     * @param   string  $filename   Name for the downloaded file (extension will be set automatically)
     * @param   string  $target     Save location
     * @return  void
     */
    public function saveFile($filename, $target = NULL){

        if(!isset($filename)){
            $filename = date('YmdHis');
        }
        if(!isset($target)){
            // write CSV output to browser
            $target = 'php://output';
        }

        // set HTTP response header
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename='.$filename.'.csv');

        $fp = fopen($target, 'w');
        foreach($this->csv_data as $row){
            fputcsv($fp, $row, $this->delimiter);
        }
        fclose($fp);
        
        // since there must be no data below
        exit();
    }

    /**
     * Set CSV data
     * 
     * @param   array   $values An array contains ordered value of arrays for all fields
     * @return  void
     */
    public function setData($values){
        if(!is_array($values)){
            $values = array($values);
        }
        $this->csv_data = $values;
    }

    /**
     * Set character for delimiter
     * 
     * @param   string  $delimiter  Commonly used character can be a comma, semicolon, tab, or space
     * @return  void
     */
    public function setDelimiter($delimiter = ','){
        $this->delimiter = $delimiter;
    }
}
?>
