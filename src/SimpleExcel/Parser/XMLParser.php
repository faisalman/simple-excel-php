<?php

namespace SimpleExcel\Parser;

use SimpleExcel\Enums\SimpleExcelException;

/**
 * SimpleExcel class for parsing Microsoft Excel 2003 XML Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */ 
class XMLParser extends BaseParser
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
    * @access   protected
    * @param    object  $attrs_obj
    * @return   array
    */
    protected function getAttributes($attrs_obj) {
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
     * Process the loaded file/string
     *
     * @param    SimpleXMLElement $xml   SimpleXMLElement object of XML
     * @throws   Exception               If document namespace invalid
     * @return bool
    */
    protected function parseDOM ($xml) {
    
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
    public function loadFile($file_path, $options = NULL) {    
        if ($this->checkFile($file_path)) {
            $this->parseDOM(simplexml_load_file($file_path));
        }
    }
    
    /**
     * Load the string to be parsed
     *
     * @param    string  $str    String with XML format
     * @return bool
     */
    public function loadString ($str, $options = NULL) {
        $this->parseDOM(simplexml_load_string($str));
    }
}
