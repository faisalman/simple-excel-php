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
    * @var string
    */
    protected $file_extension = 'html';

    /**
     * Process the loaded file/string
     *
     * @param DOMDocument $html DOMDocument object of HTML
     * @return bool
     */
    private function parseDOM(DOMDocument $html)
    {
        $tables = $html->getElementsByTagName('table');
        $field = array();

        $validNode = function ($node) {
            if (XML_ELEMENT_NODE === $node->nodeType && in_array($node->nodeName, array('th', 'td'), true)) {
                return true;
            }

            return false;
        };

        if (!$tables instanceof \DOMNodeList || !$tables->length) {
            return false;
        }

        foreach ($tables as $table) {
            $childTable = $table->childNodes;

            foreach ($childTable as $tableWrap) {
                if (XML_ELEMENT_NODE !== $tableWrap->nodeType) {
                    continue;
                }

                $nodeName = strtolower($tableWrap->nodeName);

                if (in_array($nodeName, array('thead', 'tbody', 'tfoot'), true)) {
                    $tableWrapChild = $tableWrap->childNodes;
                    foreach ($tableWrapChild as $tr) {
                        if ($tr->nodeType === XML_ELEMENT_NODE && $tr->nodeName === "tr") {
                            $row = array();
                            $tr_child = $tr->childNodes;
                            foreach ($tr_child as $td) {
                                if ($validNode($td)) {
                                    array_push($row, $td->nodeValue);
                                }
                            }

                            array_push($field, $row);
                        }
                    }
                } elseif ('tr' === $nodeName) {
                    $row = array();
                    $tableWrapChild = $tableWrap->childNodes;

                    foreach ($tableWrapChild as $td) {
                        if ($validNode($td)) {
                            array_push($row, $td->nodeValue);
                        }
                    }

                    array_push($field, $row);
                }
            }
        }


        $this->table_arr = $field;

        return true;
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
            return false;
        }

        $html = new DOMDocument('1.0', 'UTF-8');
        $sp = mb_convert_encoding(file_get_contents($filePath), 'HTML-ENTITIES', 'UTF-8');

        if ($html->loadHTML($sp)) {
            $html->encoding = 'UTF-8';
            return $this->parseDOM($html);
        }

        return false;
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

        if ($html->loadHTML($sp)) {
            $html->encoding = 'UTF-8';
            return $this->parseDOM($html);
        }

        return false;
    }
}
