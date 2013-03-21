<?php

namespace SimpleExcel\Writer;

use SimpleExcel\Enums\SimpleExcelException;
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
    public function exportFile ($target, $options = NULL) {
        if ($target == 'php://output') {
            if (!isset($options['filename'])) {
                $options['filename'] = date('Y-m-d-H-i-s');
            }
            if (strcasecmp(substr($options['filename'], strlen($this->file_extension) * -1), $this->file_extension) != 0) {
                $options['filename'] = $options['filename'] . '.' . $this->file_extension;
            }            
            // set HTTP response header
            header('Content-Type: '.$this->content_type);
            header('Content-Disposition: attachment; filename='.$options['filename']);
        }

        $fp = fopen($target, 'w');
        fwrite($fp, $this->toString());
        fclose($fp);

        // since there must be no data below exported document
        exit();
    }
    
    /**
     * @return  string
     */
    public function toString ($options = NULL) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
}
?>
