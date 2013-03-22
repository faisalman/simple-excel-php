<?php

namespace SimpleExcel\Writer;

use SimpleExcel\Spreadsheet\Cell;

/**
 * SimpleExcel class for writing table as JSON
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class JSONWriter extends BaseWriter
{
    /**
     * Defines content-type for HTTP header
     * 
     * @access  protected
     * @var     string
     */
    protected $content_type = 'application/json';

    /**
     * Defines file extension to be used when saving file
     * 
     * @access  protected
     * @var     string
     */
    protected $file_extension = 'json';
    
    /**
     * Get document content as string
     * 
	 * @param   array   $options    Options
     * @return  string              Content of document
     */
    public function toString ($options = NULL) {
        $json = array();
        $sheet = array();
        foreach ($this->workbook->getWorksheets() as $i => $worksheet) {
            foreach ($worksheet->getRecords() as $record) {
                $row = array();
                for ($i = 0; $i < count($record); $i++) {
                    $row[$i] = $record[$i]->value;
                }
                array_push($sheet, (object)$row);
            }
            array_push($json, $sheet);
        }
        return json_encode($json);
    }
}