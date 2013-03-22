<?php

namespace SimpleExcel\Writer;

/**
 * SimpleExcel class for writing CSV Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class CSVWriter extends BaseWriter
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
	 * @param   array   $options    Options
     * @return  string              Content of document
     */
    public function toString ($options = NULL) {
        if (isset($options['delimiter'])) {
            $this->delimiter = $options['delimiter'];
        }
        $fp = fopen('php://temp', 'r+');
        foreach ($this->workbook->getWorksheets() as $worksheet) {
            foreach ($worksheet->getRecords() as $record) {
                $row = array();
                foreach ($record as $cell) {
                    array_push($row, $cell->value);
                }
                fputcsv($fp, $row, $this->delimiter);
            }
        }
        rewind($fp);
        $content = stream_get_contents($fp);
        fclose($fp);
        return $content;
    }
}
?>
