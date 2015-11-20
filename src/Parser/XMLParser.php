<?php

namespace SimpleExcel\Parser;

use SimpleExcel\Exception\SimpleExcelException;

/**
 * SimpleExcel class for parsing Microsoft Excel 2003 XML Spreadsheet
 *
 * @author  Faisalman
 * @package SimpleExcel
 */
class XMLParser extends BaseParser implements IParser
{
    /**
    * Defines valid file extension
    *
    * @access   protected
    * @var      string
    */
    protected $file_extension = 'xml';

    /**
    * Extract attributes from SimpleXMLElement object
    *
    * @access   private
    * @param    object  $attrs_obj
    * @return   array
    */
    private function getAttributes($attrs_obj) {
        $attrs_arr = array();
        foreach ($attrs_obj as $attrs) {
            $attrs = (array) $attrs;
            foreach ($attrs as $attr) {
                $attr_keys = array_keys($attr);
                $attrs_arr[$attr_keys[0]] = $attr[$attr_keys[0]];
            }
        }
        return $attrs_arr;
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

        return [];
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
    * Get data of all cells as an array
    *
    * @param    bool    $val_only   Returns (value only | complete data) for every cell, default to TRUE
    * @return   array
    * @throws   Exception   If the field is not set.
    */
    public function getField($val_only = TRUE) {
        if (!$this->isFieldExists()) {
            throw new \Exception('Field is not set', SimpleExcelException::FIELD_NOT_FOUND);
        }
        if($val_only){
            $field = array();
            foreach($this->table_arr['table_contents'] as $row){
                $cells = array();
                if($row['row_contents']){
                    foreach($row['row_contents'] as $cell){
                        array_push($cells, $cell['value']);
                    }
                }
                array_push($field, $cells);
            }
            return $field;
        } else {
            return $this->table_arr;
        }
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
    * Check whether a specified column exists
    *
    * @param    int     $col_num    Column number
    * @return   bool
    */
    public function isColumnExists($col_num){
        $exist = false;
        foreach($this->table_arr['table_contents'] as $row){
            if(is_array($row['row_contents'])){
                if(array_key_exists($col_num-1, $row['row_contents'])){
                    $exist = true;
                }
            }
        }
        return $exist;
    }

    /**
    * Check whether a specified row exists
    *
    * @param    int     $row_num    Row number
    * @return   bool
    */
    public function isRowExists($row_num){
        return array_key_exists($row_num-1, $this->table_arr['table_contents']);
    }

    /**
     * Process the loaded file/string
     *
     * @param    SimpleXMLElement $xml   SimpleXMLElement object of XML
     * @throws   Exception               If document namespace invalid
     * @return bool
    */
    private function parseDOM($xml){

        // get XML namespace
        $xmlns = $xml->getDocNamespaces();

        // check file extension and XML namespace
        if ($xmlns['ss'] != 'urn:schemas-microsoft-com:office:spreadsheet') {
            throw new \Exception('Document namespace isn\'t a valid Excel XML 2003 Spreadsheet', SimpleExcelException::INVALID_DOCUMENT_NAMESPACE);
        }

        // extract document properties
        $doc_props = (array)$xml->DocumentProperties;
        $this->table_arr['doc_props'] = $doc_props;

        $rows = $xml->Worksheet->Table->Row;
        $row_num = 1;
        $this->table_arr = array(
            'doc_props' => array(),
            'table_contents' => array()
        );

        // loop through all rows
        foreach ($rows as $row) {

            // check whether ss:Index attribute exist in this row
            $row_index = $row->xpath('@ss:Index');

            // if exist, push empty value until the specified index
            if (count($row_index) > 0) {
                $gap = $row_index[0]-count($this->table_arr['table_contents']);
                for($i = 1; $i < $gap; $i++){
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
                        array_push ($row_arr, array(
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
     * Load the XML file to be parsed
     *
     * @param    string  $file_path  Path to XML file
     * @return bool
     */
    public function loadFile($file_path) {

        if (!$this->isFileReady($file_path)) {
            return false;
        }

        return $this->parseDOM(simplexml_load_file($file_path));
    }

    /**
     * Load the string to be parsed
     *
     * @param    string  $str    String with XML format
     * @return bool
     */
    public function loadString($str){
        return $this->parseDOM(simplexml_load_string($str));
    }
}
