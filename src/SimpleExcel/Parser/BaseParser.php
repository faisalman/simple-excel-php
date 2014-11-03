<?php

namespace SimpleExcel\Parser;

use SimpleExcel\Enums\SimpleExcelException;
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
    * @param    Workbook    reference to workbook
    */
    public function __construct(&$workbook) {
        $this->workbook = &$workbook;
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
    protected function checkFile($file_path) {
    
        // file exists?
        if (!file_exists($file_path)) {
        
            throw new \Exception('File '.$file_path.' doesn\'t exist', SimpleExcelException::FILE_NOT_FOUND);
        
        // extension valid?
        } else if (($handle = fopen($file_path, 'r')) === FALSE) {            
        
            throw new \Exception('Error reading the file in'.$file_path, SimpleExcelException::ERROR_READING_FILE);
            fclose($handle);
        } else {
            return TRUE;
        }
    }

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
		    $this->loadString(file_get_contents($file_path), $options);
		}
	}
}
