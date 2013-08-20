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
     * @param   Workbook    reference to workbook
     */
    public function __construct(&$workbook){
        $this->workbook = &$workbook;
    }

    /**
	 * @param    string  $target     File pointer
	 * @param    array   $options    Options
     */
    public function exportFile ($target, $options = NULL) {
        // check if target is browser
        if ($is_browser = (PHP_SAPI != 'cli' && $target == 'php://output')) {
            if (!isset($options['filename'])) {
                $options['filename'] = date('Y-m-d-H-i-s');
            }
            // check if no extension is set
            if (!preg_match('/\.\w+$/', $options['filename'])) {
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
        if ($is_browser) {
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
