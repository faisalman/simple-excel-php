<?php

namespace Faisalman\SimpleExcel\Writer;

/**
 * SimpleExcel class for writing TSV Spreadsheet
 *  
 * @author  Faisal Salman
 * @package Faisalman\SimpleExcel
 */
class TSVWriter extends CSVWriter
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
}