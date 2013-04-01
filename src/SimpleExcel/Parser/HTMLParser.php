<?php

namespace SimpleExcel\Parser;

use SimpleExcel\Enums\SimpleExcelException;
use SimpleExcel\Spreadsheet\Workbook;
use SimpleExcel\Spreadsheet\Worksheet;

/**
 * SimpleExcel class for parsing HTML table
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */ 
class HTMLParser extends BaseParser implements IParser
{
    /**
    * Defines valid file extension
    * 
    * @access   protected
    * @var      string
    */
    protected $file_extension = 'html';
    
    /**
    * Process the loaded file/string
    * 
    * @param    DOMDocument $html   DOMDocument object of HTML
    */
    protected function parseDOM($html){
        $this->workbook = new Workbook();
        $tables = $html->getElementsByTagName('table');    
        foreach ($tables as $table) {
            $sheet = new Worksheet();
            $table_child = $table->childNodes;
            foreach ($table_child as $twrap) {
                if($twrap->nodeType === XML_ELEMENT_NODE) {
                    if ($twrap->nodeName === "thead" || $twrap->nodeName === "tbody") {
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
                                $sheet->insertRecord($row);
                            }
                        }                        
                    } else if ($twrap->nodeName === "tr") {
                        $row = array();
                        $twrap_child = $twrap->childNodes;
                        foreach ($twrap_child as $td) {
                            if ($td->nodeType === XML_ELEMENT_NODE && ($td->nodeName === "th" || $td->nodeName === "td")) {
                                array_push($row, $td->nodeValue);
                            }
                        }
                        $sheet->insertRecord($row);
                    }
                }
            }
            $this->workbook->insertWorksheet($sheet);
        }
    }
        
    /**
    * Load the string to be parsed
    * 
    * @param    string  $str        String with HTML format
	* @param    array   $options    Options
    */
    public function loadString($str, $options = NULL){
        $html = new \DOMDocument();        
        $html->loadHTML($str);
        $this->parseDOM($html);
    }
}
