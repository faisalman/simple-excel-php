<?php

namespace SimpleExcel\Parser;

use SimpleExcel\Enums\SimpleExcelException;
use SimpleExcel\Spreadsheet\Cell;
use SimpleExcel\Spreadsheet\Workbook;
use SimpleExcel\Spreadsheet\Worksheet;

/**
 * SimpleExcel class for parsing JSON table
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */ 
class JSONParser extends BaseParser
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
	* @param    array   $options    Options
    */
    public function loadFile ($file_path, $options = NULL) {    
	    if ($this->checkFile($file_path)) {
            $handle = fopen($file_path, 'r');
            $contents = fread($handle, filesize($file_path));
            $this->loadString($contents, $options);
            fclose($handle);
		}
    }
    
    /**
    * Load the string to be parsed
    * 
    * @param    string  $str        String with JSON format
	* @param    array   $options    Options
    * @throws   Exception           If JSON format is invalid (or too deep)
    */
    public function loadString ($str, $options = NULL) {
        $this->workbook = new Workbook();
        if (($workbook = json_decode(utf8_encode($str), false, 5)) === NULL) {
            throw new \Exception('Invalid JSON format: '.$str, SimpleExcelException::MALFORMED_JSON);
        } else {
            foreach ($workbook as $worksheet) {
                $sheet = new Worksheet();
                $rows = array();
                foreach ($worksheet as $record) {
                    $row = array();
                    foreach ($record as $cell) {
                        array_push($row, new Cell($cell));
                    }
                    array_push($rows, $row);
                }
                $sheet->setRecords($rows);
                $this->workbook->insertWorksheet($sheet);
            }
        }
    }
}
