<?php

namespace SimpleExcel\Writer;

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
    public function __construct(Workbook $workbook){
        $this->workbook = $workbook;
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

        // set HTTP response header
        header('Content-Type: '.$this->content_type);
        header('Content-Disposition: attachment; filename='.$filename.'.'.$this->file_extension);

        $fp = fopen($target, 'w');
        fwrite($fp, $this->saveString());
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
        return $this->workbook->getWorksheet(1)->getCell(1, 1)->value;
    }
}
?>
