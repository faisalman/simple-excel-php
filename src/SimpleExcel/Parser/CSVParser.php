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
    protected $file_extension = 'CSV';

    /**
    * Load the CSV file to be parsed
    * 
    * @param    string  $file_path  Path to CSV file
    * @throws   Exception           If file being loaded doesn't exist
    * @throws   Exception           If file extension doesn't match with CSV
    * @throws   Exception           If error reading the file
    */
    public function loadFile($file_path){

        $file_extension = strtoupper(pathinfo($file_path, PATHINFO_EXTENSION));

        if (!file_exists($file_path)) {
            throw new \Exception('File '.$file_path.' doesn\'t exist', SimpleExcelException::FILE_NOT_FOUND);
        } else if ($file_extension != $this->file_extension){
            throw new \Exception('File extension '.$file_extension.' doesn\'t match with '.$this->file_extension, SimpleExcelException::FILE_EXTENSION_MISMATCH);
        }

        if (($handle = fopen($file_path, 'r')) === FALSE) {            
        
            throw new \Exception('Error reading the file in'.$file_path, SimpleExcelException::ERROR_READING_FILE);
        
        } else {

            $this->table_arr = array();
            
            if(!isset($this->delimiter)){
                $numofcols = NULL;
                // assume the delimiter is semicolon
                while(($line = fgetcsv($handle, 0, ';')) !== FALSE){
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
                    while(($line = fgetcsv($handle, 0, ',')) !== FALSE){
                        array_push($this->table_arr, $line);
                    }
                }
            } else {
                while(($line = fgetcsv($handle, 0, $this->delimiter)) !== FALSE){
                    array_push($this->table_arr, $line);
                }
            }

            fclose($handle);
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
