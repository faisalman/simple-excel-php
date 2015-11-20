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

use SimpleExcel\Exception\SimpleExcelException;
use SimpleXMLElement;

/**
 * SimpleExcel class for parsing Microsoft Excel 2003 XML Spreadsheet
 *
 * @package SimpleExcel\Parser
 */
class XMLParser extends BaseParser implements IParser
{
    /**
    * Defines valid file extension
    *
    * @var string
    */
    protected $file_extension = 'xml';

    /**
    * Extract attributes from SimpleXMLElement object
    *
    * @param object $attributesObject
    * @return array
    */
    private function getAttributes($attributesObject)
    {
        $attributesArray = array();

        foreach ($attributesObject as $attributes) {
            $attributes = (array) $attributes;
            foreach ($attributes as $attribute) {
                $attributeKeys = array_keys($attribute);
                $attributesArray[$attributeKeys[0]] = $attribute[$attributeKeys[0]];
            }
        }

        return $attributesArray;
    }

    /**
     * {@inheritdoc}
     *
     * @param  int  $rowNum  Row number
     * @param  int  $colNum  Column number
     * @param  bool $valOnly Returns (value only or complete data) for every cell, default to true [Optional]
     * @return array
     *
     * @throws \Exception If the cell identified doesn't exist.
     */
    public function getCell($rowNum, $colNum, $valOnly = true)
    {
        if (!$this->isCellExists($rowNum, $colNum)) {
            throw new \Exception(
                sprintf("Cell %s,%s doesn't exist", $rowNum, $colNum),
                SimpleExcelException::CELL_NOT_FOUND
            );
        }

        if (is_array($this->table_arr['table_contents'][$rowNum - 1]['row_contents'])) {
            if (array_key_exists($colNum - 1, $this->table_arr['table_contents'][$rowNum - 1]['row_contents'])) {
                $cell = $this->table_arr['table_contents'][$rowNum - 1]['row_contents'][$colNum - 1];
                if (!$valOnly) {
                    return $cell;
                } else {
                    return $cell['value'];
                }
            }
        }

        return array();
    }

    /**
     * {@inheritdoc}
     *
     * @param int  $colNum  Column number
     * @param bool $valOnly Returns (value only or complete data) for every cell, default to true [Optional]
     *
     * @return array
     *
     * @throws \Exception If the column requested doesn't exist.
     */
    public function getColumn($colNum, $valOnly = true)
    {
        $colArr = array();

        if (!$this->isColumnExists($colNum)) {
            throw new \Exception(
                sprintf("Column %s doesn't exist", $colNum),
                SimpleExcelException::COLUMN_NOT_FOUND
            );
        }

        foreach ($this->table_arr['table_contents'] as $row) {
            if ($row['row_contents']) {
                if (!$valOnly) {
                    array_push($colArr, $row['row_contents'][$colNum - 1]);
                } else {
                    array_push($colArr, $row['row_contents'][$colNum - 1]['value']);
                }
            }

            array_push($colArr, '');
        }

        return $colArr;
    }

    /**
     * {@inheritdoc}
     *
     * @param  bool $valOnly Returns (value only or complete data). Default to true [Optional]
     * @return array
     *
     * @throws \Exception If the field is not set.
     */
    public function getField($valOnly = true)
    {
        if (!$this->isFieldExists()) {
            throw new \Exception('Field is not set', SimpleExcelException::FIELD_NOT_FOUND);
        }

        if ($valOnly) {
            $field = array();
            foreach ($this->table_arr['table_contents'] as $row) {
                $cells = array();
                if ($row['row_contents']) {
                    foreach ($row['row_contents'] as $cell) {
                        array_push($cells, $cell['value']);
                    }
                }
                array_push($field, $cells);
            }

            return $field;
        }

        return $this->table_arr;
    }

    /**
     * {@inheritdoc}
     *
     * @param int $rowNum   Row number
     * @param bool $valOnly Returns (value only or complete data) for every cell, default to true [Optional]
     * @return array
     *
     * @throws \Exception When a row is requested that doesn't exist.
     */
    public function getRow($rowNum, $valOnly = true)
    {
        if (!$this->isRowExists($rowNum)) {
            throw new \Exception(
                sprintf("Row %s doesn't exist", $rowNum),
                SimpleExcelException::ROW_NOT_FOUND
            );
        }

        $row = $this->table_arr['table_contents'][$rowNum - 1]['row_contents'];
        $row_arr = array();

        foreach ($row as $cell) {
            if (!$rowNum) {
                array_push($row_arr, $cell);
            } else {
                array_push($row_arr, $cell['value']);
            }
        }

        return $row_arr;
    }

    /**
     * {@inheritdoc}
     *
     * @param  int $colNum Column number
     * @return bool
     */
    public function isColumnExists($colNum)
    {
        $exist = false;

        foreach ($this->table_arr['table_contents'] as $row) {
            if (is_array($row['row_contents'])) {
                if (array_key_exists($colNum - 1, $row['row_contents'])) {
                    $exist = true;
                }
            }
        }

        return $exist;
    }

    /**
     * {@inheritdoc}
     *
     * @param int $rowNum Row number
     * @return bool
     */
    public function isRowExists($rowNum)
    {
        return array_key_exists($rowNum - 1, $this->table_arr['table_contents']);
    }

    /**
     * Process the loaded file/string.
     *
     * @param SimpleXMLElement $xml SimpleXMLElement object of XML
     * @return bool
     * @throws \Exception If document namespace invalid
     */
    private function parseDOM($xml)
    {
        $xmlns = $xml->getDocNamespaces();

        if ($xmlns['ss'] != 'urn:schemas-microsoft-com:office:spreadsheet') {
            throw new \Exception(
                "Document namespace isn't a valid Excel XML 2003 Spreadsheet",
                SimpleExcelException::INVALID_DOCUMENT_NAMESPACE
            );
        }

        $doc_props = (array) $xml->DocumentProperties;
        $this->table_arr['doc_props'] = $doc_props;

        $rows = $xml->Worksheet->Table->Row;
        $row_num = 1;
        $this->table_arr = array(
            'doc_props' => array(),
            'table_contents' => array()
        );

        foreach ($rows as $row) {
            $row_index = $row->xpath('@ss:Index');

            if (count($row_index) > 0) {
                $gap = $row_index[0]-count($this->table_arr['table_contents']);
                for ($i = 1; $i < $gap; $i++) {
                    array_push($this->table_arr['table_contents'], array(
                        'row_num' => $row_num,
                        'row_contents' => '',
                        //'row_attrs' => $row_attrs_arr
                    ));

                    $row_num += 1;
                }
            }

            $cells = $row->Cell;
            $row_attrs = $row->xpath('@ss:*');
            $row_attrs_arr = $this->getAttributes($row_attrs);
            $row_arr = array();
            $col_num = 1;

            // loop through all row's cells
            foreach ($cells as $cell) {
                // check whether ss:Index attribute exist
                $cell_index = $cell->xpath('@ss:Index');

                // if exist, push empty value until the specified index
                if (count($cell_index) > 0) {
                    $gap = $cell_index[0]-count($row_arr);
                    for ($i = 1; $i < $gap; $i++) {
                        array_push($row_arr, array(
                            'row_num' => $row_num,
                            'col_num' => $col_num,
                            'datatype' => '',
                            'value' => '',
                            //'cell_attrs' => '',
                            //'data_attrs' => ''
                        ));

                        $col_num += 1;
                    }
                }

                // get all cell and data attributes
                //$cell_attrs = $cell->xpath('@ss:*');
                //$cell_attrs_arr = $this->getAttributes($cell_attrs);
                $data_attrs = $cell->Data->xpath('@ss:*');
                $data_attrs_arr = $this->getAttributes($data_attrs);
                $cell_datatype = $data_attrs_arr['Type'];

                // extract data from cell
                $cell_value = (string) $cell->Data;

                // escape input from HTML tags
                $cell_value = filter_var($cell_value, FILTER_SANITIZE_SPECIAL_CHARS);

                // push column array
                array_push($row_arr, array(
                    'row_num' => $row_num,
                    'col_num' => $col_num,
                    'datatype' => $cell_datatype,
                    'value' => $cell_value,
                    //'cell_attrs' => $cell_attrs_arr,
                    //'data_attrs' => $data_attrs_arr
                ));

                $col_num += 1;
            }

            // push row array
            array_push($this->table_arr['table_contents'], array(
                'row_num' => $row_num,
                'row_contents' => $row_arr,
                //'row_attrs' => $row_attrs_arr
            ));

            $row_num += 1;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $filePath Path to XML file.
     * @return bool
     */
    public function loadFile($filePath)
    {

        if (!$this->isFileReady($filePath)) {
            return false;
        }

        return $this->parseDOM(simplexml_load_file($filePath));
    }

    /**
     * {@inheritdoc}
     *
     * @param string $string String with XML format
     * @return bool
     */
    public function loadString($string)
    {
        return $this->parseDOM(simplexml_load_string($string));
    }
}
