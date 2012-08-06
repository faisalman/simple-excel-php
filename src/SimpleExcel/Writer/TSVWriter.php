<?php

namespace SimpleExcel\Writer;

/**
 * SimpleExcel class for writing TSV Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class TSVWriter extends CSVWriter implements IWriter
{
    /**
     * Defines content-type for HTTP header
     * 
     * @access  protected
     * @var     string
     */
    protected $content_type = 'text/tab-separated-values';

    /**
     * Defines delimiter char
     * 
     * @access  protected
     * @var     string
     */
    protected $delimiter = "\t";

    /**
     * Defines file extension to be used when saving file
     * 
     * @access  protected
     * @var     string
     */
    protected $file_extension = 'tsv';
    
    /**
    * Override parent class, this method is ignored in TSV
    */
    public function setDelimiter($delimiter){
        // do nothing
    }
}
?>
