<?php
 
namespace SimpleExcel\Parser;

/**
 * SimpleExcel class for parsing Microsoft Excel XLSX Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class XLSXParser extends BaseParser implements IParser
{
    /**
    * Defines valid file extension
    * 
    * @access   protected
    * @var      string
    */
    protected $file_extension = 'xlsx';
    
    /**
    * Load an XLSX file to be parsed
    * 
    * @param    string  $file_path  Path to XLSX file
    */
    public function loadFile($file_path) { }
    
    /**
    * Load the string to be parsed
    * 
    * @param    string  $str    String with XLSX format
    */
    public function loadString($str) { }
}
