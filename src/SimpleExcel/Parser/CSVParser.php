<?php
 
namespace SimpleExcel\Parser;

use SimpleExcel\Exception\SimpleExcelException;

/**
 * SimpleExcel class for parsing Microsoft Excel CSV Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class CSVParser extends BaseParser implements IParser
{    
    /**
    * Defines delimiter character
    * 
    * @access   protected
    * @var      string
    */
    protected $delimiter;
    
    /**
    * Defines valid file extension
    * 
    * @access   protected
    * @var      string
    */
    protected $file_extension = 'csv';

    /**
    * Load the CSV file to be parsed
    * 
    * @param    string  $file_path  Path to CSV file
    */
    public function loadFile($file_path){
    
        if (!$this->isFileReady($file_path)) {
            return;
        }

        $this->loadString(file_get_contents($file_path));
    }
    
    /**
    * Load the string to be parsed
    * 
    * @param    string  $str    String with CSV format
    */
    public function loadString($str){
        $this->table_arr = array();
        
        if(!isset($this->delimiter)){
            $numofcols = NULL;
            // assume the delimiter is semicolon
            while(($line = str_getcsv($str, ';')) !== FALSE){
                if($numofcols === NULL){
                    $numofcols = count($line);
                }
                // check the number of values in each line
                if(count($line) === $numofcols){
                    array_push($this->table_arr, $line);
                } else {
                    // maybe wrong delimiter
                    // empty the array back
                    $this->table_arr = array();
                    $numofcols = NULL;
                    break;
                }
            }
            // if null, check whether values are separated by commas
            if($numofcols === NULL){
                while(($line = str_getcsv($str, ',')) !== FALSE){
                    array_push($this->table_arr, $line);
                }
            }
        } else {
            while(($line = str_getcsv($str, $this->delimiter)) !== FALSE){
                array_push($this->table_arr, $line);
            }
        }
    }
    
    /**
    * Set delimiter that should be used to parse CSV document
    * 
    * @param    string  $delimiter   Delimiter character
    */
    public function setDelimiter($delimiter){
        $this->delimiter = $delimiter;
    }
}
