<?php

namespace SimpleExcel\Writer;

use SimpleExcel\Exception\SimpleExcelException;
use SimpleExcel\Spreadsheet\Workbook;

/**
 * SimpleExcel base class for writing spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
abstract class BaseWriter implements IWriter
{
    /**
    * Holds the workbook instance
    * 
    * @access   protected
    * @var      Workbook
    */
    protected $workbook;
    
    /**
     * Defines content-type for HTTP header
     * 
     * @access  protected
     * @var     string
     */
    protected $content_type = 'text';

    /**
     * Defines file extension to be used when saving file
     * 
     * @access  protected
     * @var     string
     */
    protected $file_extension = 'txt';

    /**
     * @return  void
     */
    public function __construct(&$workbook){
        $this->workbook = &$workbook;
    }
    
    /**
     * @return  void
     */
    public function exportFile ($filename, $target, $options = NULL) {
        
        if (!isset($filename)) {
            $filename = date('Y-m-d-H-i-s');
        }
        if (!isset($target)) {
            // write output to browser
            $target = 'php://output';
        }
        if (strcasecmp(substr($filename, strlen($this->file_extension) * -1), $this->file_extension) != 0) {
            $filename = $filename . '.' . $this->file_extension;
        }

        // set HTTP response header
        header('Content-Type: '.$this->content_type);
        header('Content-Disposition: attachment; filename='.$filename);

        $fp = fopen($target, 'w');
        fwrite($fp, $this->toString());
        fclose($fp);

        if ($target == 'php://output') {
            // since there must be no data below
            exit();
        }
    }
    
    /**
     * @return  string
     */
    public function toString ($options = NULL) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
}
?>
