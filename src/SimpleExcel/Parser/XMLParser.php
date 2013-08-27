<?php

namespace SimpleExcel\Parser;

use SimpleExcel\Enums\Datatype;
use SimpleExcel\Enums\SimpleExcelException;
use SimpleExcel\Spreadsheet\Cell;
use SimpleExcel\Spreadsheet\Workbook;
use SimpleExcel\Spreadsheet\Worksheet;

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
     * Load the string to be parsed
     *
     * @param    string  $str       String with XML format
	 * @param    array   $options   Options
     * @throws   Exception               If document namespace invalid
     * @return bool
     */
    public function loadString ($str, $options = NULL) {
        $xml = simplexml_load_string($str);
        $this->workbook = new Workbook();
        $xmlns = $xml->getDocNamespaces();
        if ($xmlns['ss'] != 'urn:schemas-microsoft-com:office:spreadsheet') {
            throw new \Exception('Document namespace isn\'t a valid Excel XML 2003 Spreadsheet', SimpleExcelException::INVALID_DOCUMENT_NAMESPACE);
        }
        foreach($xml->Worksheet as $worksheet) {
            $sheet = new Worksheet();
            $col_max = 0;
            foreach ($worksheet->Table->Row as $row) {
                $record = array();
                $row_index = $row->xpath('@ss:Index');
                if (count($row_index) > 0) {
                    $gap = $row_index[0] - count($sheet->getRecords());
                    for($i = 1; $i < $gap; $i++){
                        $sheet->insertRecord(array());
                    }
                }
                $record = array();
                $col_num = 0;
                foreach ($row->Cell as $cell) {
                    $cell_index = $cell->xpath('@ss:Index');
                    if (count($cell_index) > 0) {
                        $gap = $cell_index[0] - count($record);
                        for ($i = 1; $i < $gap; $i++) {
                            array_push($record, new Cell(''));
                        }
                    }                    
                    $data_attrs = $cell->Data->xpath('@ss:*');
                    $cell_datatype = $data_attrs['Type'];
                    switch ($cell_datatype) {
                        case 'Number':
                            $cell_datatype = Datatype::NUMBER;
                            break;
                        case 'DateTime':
                            $cell_datatype = Datatype::DATETIME;
                            break;
                        case 'Error':
                            $cell_datatype = Datatype::ERROR;
                            break;
                        case 'String':
                        default:
                            $cell_datatype = Datatype::TEXT;
                    }
                    $cell_value = (string) $cell->Data;
                    array_push($record, new Cell($cell_value, $cell_datatype));
                    $col_num += 1;
                }
                if ($col_num > $col_max) {
                    $col_max = $col_num;
                }
                $sheet->insertRecord($record);
            }
            foreach ($sheet->getRecords() as $i => $record) {
                if (($diff = $col_max - count($record)) > 0) {
                    $record = $sheet->getRecord($i + 1);
                    for ($j = 0; $j < $diff; $j++) {
                        array_push($record, new Cell(''));
                    }
                }
            }
            $this->workbook->insertWorksheet($sheet);
        }
    }
}
