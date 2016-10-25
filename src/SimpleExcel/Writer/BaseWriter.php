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
     * Holds tabular data
     *
     * @access  protected
     * @var     array
     */
    protected $tabl_data;

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
    public function __construct(){
        $this->tabl_data = array();
    }

    /**
     * Adding row data to table
     *
     * @param   array   $values An array contains ordered value for every cell
     * @param   bool    Check if row goes at the beginning or end of array
     * @return  void
     */
    public function addRow($values, $end = TRUE)
    {
        if (!is_array($values)) {
            $values = array($values);
        }
        if ($end) {
            array_push($this->tabl_data, $values);
            return;
        }
        array_unshift($this->tabl_data, $values);
    }

    /**
     * Get document content as string
     *
     * @return  string  Content of document
     */
    public function saveString(){
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
     * Export the document
     *
     * @param   string  $filename   Name for the saved file (extension will be set automatically)
     * @param   string  $target     Save location
     * @return  void
     */
    public function saveFile($filename, $target = NULL){

        if (!isset($filename)) {
            $filename = date('YmdHis');
        }

        if (!isset($target)) {
            // write output to browser
            $target = 'php://output';

            // set HTTP response header
            header('Content-Type: '.$this->content_type);
            header('Content-Disposition: attachment; filename='.$filename.'.'.$this->file_extension);
        }

        $fp = fopen($target, 'w');
        fwrite($fp, $this->saveString());
        fclose($fp);

        if ($target == 'php://output') {
            // since there must be no data below
            exit();
        }
    }

    /**
     * Set tabular data
     *
     * @param   array   $values An array contains ordered value of arrays for all fields
     * @return  void
     */
    public function setData($values){
        if(!is_array($values)){
            $values = array($values);
        }
        $this->tabl_data = $values;
    }
}
?>
