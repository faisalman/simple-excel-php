<?php

namespace SimpleExcel\Parser;

use SimpleExcel\Exception\SimpleExcelException;

/**
 * SimpleExcel class for parsing HTML table
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */ 
class HTMLParser extends BaseParser implements IParser
{
    /**
    * Load the HTML file to be parsed
    * 
    * @param    string  $file_path  Path to HTML file
    * @return   void
    * @throws   Exception           If file being loaded doesn't exist
    * @throws   Exception           If file extension doesn't match with HTML
    * @throws   Exception           If error reading HTML file
    */
    public function loadFile($file_path) {

        $file_extension = strtoupper(pathinfo($file_path, PATHINFO_EXTENSION));

        if (!file_exists($file_path)) {
            throw new \Exception('File '.$file_path.' doesn\'t exist', SimpleExcelException::FILE_NOT_FOUND);
        } else if ($file_extension != 'HTML') {
            throw new \Exception('File extension '.$file_extension.' doesn\'t match with HTML', SimpleExcelException::FILE_EXTENSION_MISMATCH);
        }

        // instantiate new DOMDocument object
        $html = new \DOMDocument();
        
        if (!$html->loadHTMLFile($file_path)) {
        
            throw new \Exception('Error reading the file in '.$file_path, SimpleExcelException::ERROR_READING_FILE);
        
        } else {
            
            $table = $html->getElementsByTagName('table');
            $field = array();
            
            foreach ($tables as $table) {
                $table_child = $table->childNodes;
                foreach ($table_child as $twrap) {
                    if($twrap->nodeType === XML_ELEMENT_NODE) {
                        if ($twrap->nodeName === "thead" || $twrap->nodeName === "tbody")) {
                            $twrap_child = $twrap->childNodes;
                            foreach ($twrap_child as $tr) {
                                if($tr->nodeType === XML_ELEMENT_NODE && $tr->nodeName === "tr") {
                                    $row = array();
                                    $tr_child = $tr->childNodes;
                                    foreach ($tr_child as $td) {
                                        if ($td->nodeType === XML_ELEMENT_NODE && ($td->nodeName === "th" || $td->nodeName === "td")) {
                                            array_push($row, $td->nodeValue);
                                        }
                                    }
                                    array_push($field, $row);
                                }
                            }                        
                        } else if ($twrap->nodeName === "tr") {
                            $row = array();
                            $tr_child = $tr->childNodes;
                            foreach ($tr_child as $td) {
                                if ($td->nodeType === XML_ELEMENT_NODE && ($td->nodeName === "th" || $td->nodeName === "td")) {
                                    array_push($row, $td->nodeValue);
                                }
                            }
                            array_push($field, $row);
                        }
                    }
                }
            }
            
            $this->table_arr = $field;
        }
    }
}
