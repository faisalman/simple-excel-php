<?php

namespace SimpleExcel\Parser;

use SimpleExcel\Exception\SimpleExcelException;

/**
 * SimpleExcel class for parsing JSON table
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */ 
class JSONParser extends BaseParser implements IParser
{    
    /**
    * Defines valid file extension
    * 
    * @access   protected
    * @var      string
    */
    protected $file_extension = 'JSON';
    
    /**
    * Load the JSON file to be parsed
    * 
    * @param    string  $file_path  Path to JSON file
    * @return   void
    * @throws   Exception           If file being loaded doesn't exist
    * @throws   Exception           If file extension doesn't match with JSON
    * @throws   Exception           If error reading JSON file
    */
    public function loadFile($file_path) {

        $file_extension = strtoupper(pathinfo($file_path, PATHINFO_EXTENSION));

        if (!file_exists($file_path)) {
            throw new \Exception('File '.$file_path.' doesn\'t exist', SimpleExcelException::FILE_NOT_FOUND);
        } else if ($file_extension != $this->file_extension) {
            throw new \Exception('File extension '.$file_extension.' doesn\'t match with '.$this->file_extension, SimpleExcelException::FILE_EXTENSION_MISMATCH);
        }

        if (($handle = fopen($file_path, 'r')) === FALSE) {            
            throw new \Exception('Error reading the file in'.$file_path, SimpleExcelException::ERROR_READING_FILE);
        } else {
            if (($field = json_decode(utf8_encode($handle), false, 4)) === NULL) {
                throw new \Exception('Invalid JSON format: '.$handle, SimpleExcelException::INVALID_JSON_FORMAT);
            }
            $this->table_arr = $field;
        }
        fclose($handle);
    }
}