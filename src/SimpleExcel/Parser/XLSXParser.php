<?php
 
namespace SimpleExcel\Parser;

use SimpleExcel\Enums\Datatype;
use SimpleExcel\Enums\SimpleExcelException;
use SimpleExcel\Spreadsheet\Cell;
use SimpleExcel\Spreadsheet\Workbook;
use SimpleExcel\Spreadsheet\Worksheet;

/**
 * SimpleExcel class for parsing Microsoft Excel XLSX Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class XLSXParser extends BaseParser
{
    /**
    * Defines valid file extension
    * 
    * @access   protected
    * @var      string
    */
    protected $file_extension = 'xlsx';

    /**
    * Load the file to be parsed
    * 
    * @param    string  $file_path  Path to file
    * @param    array   $options    Options
    * @throws   Exception           If file being loaded doesn't exist
    * @throws   Exception           If file extension doesn't match
    * @throws   Exception           If error reading the file
    */
    public function loadFile ($file_path, $options = NULL) {
        if ($this->checkFile($file_path)) {
            // TODO: extract zip & map string to worksheet
        }
    }

    /**
    * Load the string to be parsed
    * 
    * @param    string  $str        String with XLSX format
    * @param    array   $options    Options
    */
    public function loadString($str, $options) {
        $this->workbook = new Workbook();
        $xml = simplexml_load_string($str);
        // TODO: implement xlsx parser
    }
}
