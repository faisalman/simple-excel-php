<?php

namespace SimpleExcel\Writer;

/**
 * SimpleExcel class for writing table as JSON
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class JSONWriter extends BaseWriter implements IWriter
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
     * @return  string  Content of document
     */
    public function saveString(){
        $json = array();
        foreach ($this->tabl_data as $row) {
            $row_array = array();
            for ($i = 0; $i < count($row); $i++) {
                $row_array[$i] = $row[$i];
            }
            array_push($json, (object)$row);
        }
        return json_encode($json);
    }
}
?>
