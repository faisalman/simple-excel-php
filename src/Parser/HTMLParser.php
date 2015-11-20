<?php

/*
 +------------------------------------------------------------------------+
 | The SimpleExcel Component                                              |
 +------------------------------------------------------------------------+
 | Copyright © 2011-2013 Faisalman <fyzlman@gmail.com>                    |
 | Copyright © 2015 (c) Serghei Iakovlev <me@klay.me>                     |
 +------------------------------------------------------------------------+
 | This source file is subject to the MIT License that is bundled         |
 | with this package in the file LICENSE.md.                              |
 |                                                                        |
 | If you did not receive a copy of the license and are unable to         |
 | obtain it through the world-wide-web, please send an email             |
 | to me@klay.me so I can send you a copy immediately.                    |
 +------------------------------------------------------------------------+
*/

namespace SimpleExcel\Parser;

use DOMDocument;

/**
 * SimpleExcel class for parsing HTML table
 *
 * @package SimpleExcel\Parser
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
    private function parseDOM($html){
        $tables = $html->getElementsByTagName('table');
        $field = array();
        foreach ($tables as $table) {
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
                                array_push($field, $row);
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
                        array_push($field, $row);
                    }
                }
            }
        }
        $this->table_arr = $field;
    }

    /**
     * Load the HTML file to be parsed.
     *
     * @param string $filePath Path to HTML file.
     * @return bool
     */
    public function loadFile($filePath)
    {
        if (!$this->isFileReady($filePath)) {
            return;
        }

        $html = new DOMDocument('1.0', 'UTF-8');

	    $sp = mb_convert_encoding(file_get_contents($filePath), 'HTML-ENTITIES', 'UTF-8');
        $html->loadHTML($sp);
	    $html->encoding = 'UTF-8';
        $this->parseDOM($html);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $string String with HTML format
     * @return bool
     */
    public function loadString($string)
    {
        $html = new DOMDocument('1.0', 'UTF-8');

        $sp = mb_convert_encoding($string, 'HTML-ENTITIES', 'UTF-8');
        $html->loadHTML($sp);
	    $html->encoding = 'UTF-8';
        $this->parseDOM($html);
    }
}
