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
    * @throws   Exception           If JSON format is invalid (or too deep)
    */
    public function loadFile($file_path) {
    
        if (!$this->isFileOk) {
            return;
        }

        $handle = fopen($file_path, 'r');
        if (($this->table_arr = json_decode(utf8_encode($handle), false, 4)) === NULL) {
            throw new \Exception('Invalid JSON format: '.$handle, SimpleExcelException::INVALID_JSON_FORMAT);
        }
        fclose($handle);
    }
}