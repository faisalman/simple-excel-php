<?php

namespace SimpleExcel\Writer;

/**
 * SimpleExcel class for writing Microsoft Excel XLSX Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class XLSXWriter extends BaseWriter
{
    /**
     * Defines content-type for HTTP header
     * 
     * @access  protected
     * @var     string
     */
    protected $content_type = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

    /**
     * Defines file extension to be used when saving file
     * 
     * @access  protected
     * @var     string
     */
    protected $file_extension = 'xlsx';

    /**
     * Array containing document properties
     * 
     * @access  private
     * @var     array
     */
    private $doc_prop;

    /**
     * @return  void
     */
    public function __construct() { }
}