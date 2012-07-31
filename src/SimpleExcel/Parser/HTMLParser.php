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
    */
    public function loadFile($file_path) {
    
        if (!$this->isFileOk) {
            return;
        }

        // instantiate new DOMDocument object
        $html = new \DOMDocument();
        
        $html->loadHTMLFile($file_path);
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
