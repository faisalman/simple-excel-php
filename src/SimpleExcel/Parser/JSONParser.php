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
    */
    public function loadFile($file_path) {
    
        if (!$this->isFileOk) {
            return;
        }

        $handle = fopen($file_path, 'r');
        $this->loadString($handle);
        fclose($handle);
    }
    
    /**
    * Load the string to be parsed
    * 
    * @param    string  $str    String with JSON format
    * @throws   Exception           If JSON format is invalid (or too deep)
    */
    public function loadString($str){
        if (($this->table_arr = json_decode(utf8_encode($str), false, 4)) === NULL) {
            throw new \Exception('Invalid JSON format: '.$str, SimpleExcelException::INVALID_JSON_FORMAT);
        }
    }
}