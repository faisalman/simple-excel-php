<?php

namespace SimpleExcel\Writer;

/**
 * SimpleExcel class for writing CSV Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class CSVWriter extends BaseWriter implements IWriter
{
    /**
     * Defines content-type for HTTP header
     * 
     * @access  protected
     * @var     string
     */
    protected $content_type = 'text/csv';

    /**
     * Defines delimiter char
     * 
     * @access  protected
     * @var     string
     */
    protected $delimiter = ',';

    /**
     * Defines file extension to be used when saving file
     * 
     * @access  protected
     * @var     string
     */
    protected $file_extension = 'csv';
    
    /**
     * Get document content as string
     * 
     * @return  string  Content of document
     */
    public function saveString(){
        $fp = fopen('php://temp', 'r+');
        foreach ($this->tabl_data as $row) {
            fputcsv($fp, $row, $this->delimiter);
        }
        rewind($fp);
        $content = stream_get_contents($fp);
        fclose($fp);
        return $content;
    }

    /**
     * Set character for delimiter
     * 
     * @param   string  $delimiter  Commonly used character can be a comma, semicolon, tab, or space
     * @return  void
     */
    public function setDelimiter($delimiter){
        $this->delimiter = $delimiter;
    }
}
?>
