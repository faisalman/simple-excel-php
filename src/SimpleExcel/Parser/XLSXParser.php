<?php
 
namespace SimpleExcel\Parser;

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
    * Load the string to be parsed
    * 
    * @param    string  $str        String with XLSX format
	* @param    array   $options    Options
    */
    public function loadString($str, $options) { }
}
