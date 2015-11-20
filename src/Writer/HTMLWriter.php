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
     * @return  string  Content of document
     */
    public function saveString(){
        $content = '<table>';
        foreach ($this->tabl_data as $row) {
            $content .= '<tr>';
            foreach ($row as $cell) {
                $content .= '<td>'.$cell.'</td>';
            }
            $content .= '</tr>';
        }
        return $content.'</table>';
    }
}
?>
