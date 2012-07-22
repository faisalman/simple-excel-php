<?php
 
namespace SimpleExcel\Parser;

use SimpleExcel\Exception\SimpleExcelException;

/**
 * SimpleExcel class for parsing Microsoft Excel CSV Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class CSVParser implements IParser
{
    /**
    * Holds the parsed result
    * 
    * @access   protected
    * @var      array
    */
    protected $table_arr;
    
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
    * @param    string  $file_url   Path to CSV file (optional)
    */
    public function __construct($file_url = NULL){
        if(isset($file_url)){
            $this->loadFile($file_url);
        }
    }

    /**
    * Get value of the specified cell
    * 
    * @param    int     $row_num    Row number
    * @param    int     $col_num    Column number
    * @return   array
    * @throws   Exception           If the cell identified doesn't exist.
    */
    public function getCell($row_num, $col_num){

        // check whether the cell exists
        if(!isset($this->table_arr[$row_num-1][$col_num-1])){
            throw new \Exception('Cell '.$row_num.','.$col_num.' doesn\'t exist', SimpleExcelException::CELL_NOT_FOUND);
        }
        return $this->table_arr[$row_num-1][$col_num-1];
    }

    /**
    * Get datatype of the specified cell
    * 
    * @param    int     $row_num    Row number
    * @param    int     $col_num    Column number
    * @return   string              Returns 'String'
    * @throws   Exception           If the cell requested doesn't exist.
    */
    public function getCellDatatype($row_num, $col_num){

        // check whether the cell exists
        if(!isset($this->table_arr[$row_num-1][$col_num-1])){
            throw new \Exception('Cell '.$row_num.','.$col_num.' doesn\'t exist', SimpleExcelException::CELL_NOT_FOUND);
        }
        return 'String';
    }

    /**
    * Get data of the specified column as an array
    * 
    * @param    int     $col_num    Column number
    * @param    bool    $val_only   Ignored in CSV
    * @return   array
    * @throws   Exception           If the column requested doesn't exist.
    */
    public function getColumn($col_num, $val_only = TRUE){
        $col_arr = array();

        if(!isset($this->table_arr[0][$col_num-1])){
            throw new \Exception('Column '.$col_num.' doesn\'t exist', SimpleExcelException::COLUMN_NOT_FOUND);
        }

        // get the specified column within every row
        foreach($this->table_arr as $row){
            array_push($col_arr, $row[$col_num-1]);
        }

        // return the array, if empty then return FALSE
        return $col_arr;
    }

    /**
    * Get data of all cells as an array
    * 
    * @return   array
    * @throws   Exception   If the field is not set.
    */
    public function getField(){
        if(isset($this->table_arr)){
            return $this->table_arr;
        } else {
            throw new \Exception('Field is not set', SimpleExcelException::FIELD_NOT_FOUND);
        }
    }

    /**
    * Get data of the specified row as an array
    * 
    * @param    int     $row_num    Row number
    * @param    bool    $val_only   Ignored
    * @return   array
    * @throws   Exception           When a row is requested that doesn't exist.
    */
    public function getRow($row_num, $val_only = TRUE){
        if(!isset($this->table_arr[$row_num-1])){
            throw new \Exception('Row '.$row_num.' doesn\'t exist', SimpleExcelException::ROW_NOT_FOUND);
        }

        // return the array
        return $this->table_arr[$row_num-1];
    }

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

        if (($handle = fopen($file_path, 'r')) !== FALSE) {

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

        } else {
            throw new \Exception('Error reading the file', SimpleExcelException::ERROR_READING_FILE);
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
