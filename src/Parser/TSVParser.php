<?php
 
namespace SimpleExcel\Parser;

/**
 * SimpleExcel class for parsing Microsoft Excel TSV Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class TSVParser extends CSVParser
{
    /**
    * Defines delimiter character (TAB)
    * 
    * @access   protected
    * @var      string
    */
    protected $delimiter = "\t";
    
    /**
    * Defines valid file extension
    * 
    * @access   protected
    * @var      string
    */
    protected $file_extension = 'tsv';
    
    /**
    * Override parent class, this method is ignored in TSV
    */
    public function setDelimiter($delimiter){
        // do nothing
    }
}
