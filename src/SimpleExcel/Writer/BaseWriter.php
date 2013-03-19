<?php

namespace SimpleExcel\Writer;

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
    public function exportFile ($filename, $target) {
        
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
    public function toString () {
        $content = '';
        foreach ($this->tabl_data as $row) {
            foreach ($row as $cell) {
                $content .= $cell.'\t';
            }
            $content .= '\n';
        }
        return $content;
    }

    /**
     * @deprecated since v0.4
     */
    protected $tabl_data;
    public function addRow($values){
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    public function setData($values){
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    public function saveString(){
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    public function saveFile($filename, $target = NULL){
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
}
?>
