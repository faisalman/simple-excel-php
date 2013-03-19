<?php

namespace SimpleExcel\Parser;

use SimpleExcel\Exception\SimpleExcelException;
use SimpleExcel\Spreadsheet\Workbook;

/**
 * SimpleExcel class for parsing HTML table
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */ 
abstract class BaseParser implements IParser
{
    /**
    * Holds the workbook instance
    * 
    * @access   protected
    * @var      Workbook
    */
    protected $workbook;

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
    public function __construct(Workbook $workbook) {
        $this->workbook = $workbook;
    }
    
    /**
    * Check whether file exists, valid, and readable
    * 
    * @param    string  $file_path  Path to file
    * @return   void
    * @throws   Exception           If file being loaded doesn't exist
    * @throws   Exception           If file extension doesn't match
    * @throws   Exception           If error reading the file
    */
    protected function checkFile($file_path) {
    
        // file exists?
        if (!file_exists($file_path)) {
        
            throw new \Exception('File '.$file_path.' doesn\'t exist', SimpleExcelException::FILE_NOT_FOUND);
        
        // extension valid?
        } else if (strtoupper(pathinfo($file_path, PATHINFO_EXTENSION))!= strtoupper($this->file_extension)){

            throw new \Exception('File extension '.$file_extension.' doesn\'t match with '.$this->file_extension, SimpleExcelException::FILE_EXTENSION_MISMATCH);
        
        // file readable?
        } else if (($handle = fopen($file_path, 'r')) === FALSE) {            
        
            throw new \Exception('Error reading the file in'.$file_path, SimpleExcelException::ERROR_READING_FILE);
            fclose($handle);
        }
    }
    
    /**
    * @deprecated since v0.4
    */
    protected $table_arr;
    public function getCell($row_num, $col_num, $val_only = true) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    public function getColumn($col_num, $val_only = TRUE) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    public function getField($val_only = TRUE) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    public function getRow($row_num, $val_only = TRUE) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    public function isCellExists($row_num, $col_num){
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    public function isColumnExists($col_num){
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    public function isRowExists($row_num){
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    public function isFieldExists(){
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    public function isFileReady($file_path) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
}
