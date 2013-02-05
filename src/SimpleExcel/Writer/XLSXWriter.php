<?php

namespace SimpleExcel\Writer;

/**
 * SimpleExcel class for writing Microsoft Excel XLSX Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class XLSXWriter extends BaseWriter implements IWriter
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

    /**
     * Adding row data to XLSX
     * 
     * @param   array   $values An array contains ordered value for every cell
     * @return  void
     */
    public function addRow($values) { }
    
    /**
     * Get document content as string
     * 
     * @return  string  Content of document
     */
    public function saveString() { }

    /**
    * Set XLSX data
    * 
    * @param    array   $values An array contains ordered value of arrays for all fields
    * @return   void
    */
    public function setData($values) { }

    /**
    * Set a document property of the XLSX
    * 
    * @param    string  $prop   Document property to be set
    * @param    string  $val    Value of the document property
    * @return   void
    */
    public function setDocProp($prop, $val) {
        $this->doc_prop[$prop] = $val;
    }
}
?>
