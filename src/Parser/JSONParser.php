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
    protected $file_extension = 'json';
    
    /**
    * Load the JSON file to be parsed
    * 
    * @param    string  $file_path  Path to JSON file
    */
    public function loadFile($file_path) {
    
        if (!$this->isFileReady($file_path)) {
            return;
        }

        $handle = fopen($file_path, 'r');
        $contents = fread($handle, filesize($file_path));
        $this->loadString($contents);
        fclose($handle);
    }
    
    /**
    * Load the string to be parsed
    * 
    * @param    string  $str    String with JSON format
    * @throws   Exception           If JSON format is invalid (or too deep)
    */
    public function loadString($str){
        $field = array();
        if (($table = json_decode(utf8_encode($str), false, 4)) === NULL) {
            throw new \Exception('Invalid JSON format: '.$str, SimpleExcelException::MALFORMED_JSON);
        } else {
            foreach ($table as $rows) {
                $row = array();
                foreach ($rows as $cell) {
                    array_push($row, $cell);
                }
                array_push($field, $row);
            }
        }
        $this->table_arr = $field;
    }
}
