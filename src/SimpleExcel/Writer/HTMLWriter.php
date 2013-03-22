<?php

namespace SimpleExcel\Writer;

/**
 * SimpleExcel class for writing HTML table
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class HTMLWriter extends BaseWriter implements IWriter
{
    /**
     * Defines content-type for HTTP header
     * 
     * @access  protected
     * @var     string
     */
    protected $content_type = 'text/html';

    /**
     * Defines file extension to be used when saving file
     * 
     * @access  protected
     * @var     string
     */
    protected $file_extension = 'html';
    
    /**
     * Get document content as string
     * 
	 * @param   array   $options    Options
     * @return  string              Content of document
     */
    public function toString ($options = NULL) {
        $content = '<table>';
        foreach ($this->workbook->getWorksheets() as $worksheet) {
            foreach ($worksheet->getRecords() as $record) {
                $content .= '
 <tr>';
                foreach ($record as $cell) {
                    $content .= '
  <td>' . $cell->value . '</td>';
                }
                $content .= '
 </tr>';
            }
        }
        return $content.'
</table>';
    }
}