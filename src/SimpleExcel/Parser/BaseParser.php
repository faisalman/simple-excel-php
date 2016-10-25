<?php

namespace SimpleExcel\Parser;

use SimpleExcel\Exception\SimpleExcelException;

/**
 * SimpleExcel class for parsing HTML table
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */ 
abstract class BaseParser implements IParser
{
    /**
    * Holds the parsed result
    * 
    * @access   private
    * @var      array
    */
    protected $table_arr;
    
    /**
    * Defines valid file extension
    * 
    * @access   protected
    * @var      string
    */
    protected $file_extension = '';

    /**
    * @param    string  $file_url   Path to file (optional)
    */
    public function __construct($file_url = NULL) {
        if(isset($file_url)) {
            $this->loadFile($file_url);
        }
    }

    /**
    * Get value of the specified cell
    * 
    * @param    int $row_num    Row number
    * @param    int $col_num    Column number
    * @param    int $val_only
    * @return   array
    * @throws   Exception       If the cell identified doesn't exist.
    */
    public function getCell($row_num, $col_num, $val_only = true) {
        // check whether the cell exists
        if (!$this->isCellExists($row_num, $col_num)) {
            throw new \Exception('Cell '.$row_num.','.$col_num.' doesn\'t exist', SimpleExcelException::CELL_NOT_FOUND);
        }
        return $this->table_arr[$row_num-1][$col_num-1];
    }

    /**
    * Get data of the specified column as an array
    * 
    * @param    int     $col_num    Column number
    * @param    bool    $val_only
    * @return   array
    * @throws   Exception           If the column requested doesn't exist.
    */
    public function getColumn($col_num, $val_only = TRUE) {
        $col_arr = array();

        if(!$this->isColumnExists($col_num)){
            throw new \Exception('Column '.$col_num.' doesn\'t exist', SimpleExcelException::COLUMN_NOT_FOUND);
        }

        // get the specified column within every row
        foreach($this->table_arr as $row){
            array_push($col_arr, $row[$col_num-1]);
        }

        // return the array
        return $col_arr;
    }

    /**
    * Get data of all cells as an array
    * 
    * @param    bool    $val_only
    * @return   array
    * @throws   Exception   If the field is not set.
    */
    public function getField($val_only = TRUE) {
        if(!$this->isFieldExists()){
            throw new \Exception('Field is not set', SimpleExcelException::FIELD_NOT_FOUND);
        }
        
        // return the array
        return $this->table_arr;
    }

    /**
    * Get data of the specified row as an array
    * 
    * @param    int     $row_num    Row number
    * @param    bool    $val_only
    * @return   array
    * @throws   Exception           When a row is requested that doesn't exist.
    */
    public function getRow($row_num, $val_only = TRUE) {
        if(!$this->isRowExists($row_num)){
            throw new \Exception('Row '.$row_num.' doesn\'t exist', SimpleExcelException::ROW_NOT_FOUND);
        }

        // return the array
        return $this->table_arr[$row_num-1];
    }

    /**
    * Check whether cell with specified row & column exists
    * 
    * @param    int     $row_num    Row number
    * @param    int     $col_num    Column number
    * @return   bool
    */
    public function isCellExists($row_num, $col_num){
        return $this->isRowExists($row_num) && $this->isColumnExists($col_num);
    }
    
    /**
    * Check whether a specified column exists
    * 
    * @param    int     $col_num    Column number
    * @return   bool
    */
    public function isColumnExists($col_num){
        $exist = false;
        foreach($this->table_arr as $row){
            if(array_key_exists($col_num-1, $row)){
                $exist = true;
            }
        }
        return $exist;
    }
    
    /**
    * Check whether a specified row exists
    * 
    * @param    int     $row_num    Row number
    * @return   bool
    */
    public function isRowExists($row_num){
        return array_key_exists($row_num-1, $this->table_arr);
    }
    
    /**
    * Check whether table exists
    * 
    * @return   bool
    */
    public function isFieldExists(){
        return isset($this->table_arr);
    }
    
    /**
    * Check whether file exists, valid, and readable
    * 
    * @param    string  $file_path  Path to file
    * @return   bool
    * @throws   Exception           If file being loaded doesn't exist
    * @throws   Exception           If file extension doesn't match
    * @throws   Exception           If error reading the file
    */
    public function isFileReady($file_path) {
    
        // file exists?
        if (!file_exists($file_path)) {
        
            throw new \Exception('File '.$file_path.' doesn\'t exist', SimpleExcelException::FILE_NOT_FOUND);
        
        // extension valid?
        } else if (strtoupper(pathinfo($file_path, PATHINFO_EXTENSION))!= strtoupper($this->file_extension)){

            throw new \Exception('File extension '.strtoupper(pathinfo($file_path, PATHINFO_EXTENSION)).' doesn\'t match with '.$this->file_extension, SimpleExcelException::FILE_EXTENSION_MISMATCH);
        
        // file readable?
        } else if (($handle = fopen($file_path, 'r')) === FALSE) {            
        
            throw new \Exception('Error reading the file in'.$file_path, SimpleExcelException::ERROR_READING_FILE);
            fclose($handle);

        // okay then
        } else {
            
            return TRUE;
        }
    }
}
