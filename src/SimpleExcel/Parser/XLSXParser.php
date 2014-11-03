<?php
 
namespace SimpleExcel\Parser;

use SimpleExcel\Enums\Datatype;
use SimpleExcel\Enums\SimpleExcelException;
use SimpleExcel\Spreadsheet\Cell;
use SimpleExcel\Spreadsheet\Workbook;
use SimpleExcel\Spreadsheet\Worksheet;

/**
 * SimpleExcel class for parsing Microsoft Excel XLSX Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class XLSXParser extends BaseParser
{
    /**
    * Defines valid file extension
    * 
    * @access   protected
    * @var      string
    */
    protected $file_extension = 'xlsx';

    /**
    * Load the file to be parsed
    * 
    * @param    string  $file_path  Path to file
    * @param    array   $options    Options
    * @throws   Exception           If file being loaded doesn't exist
    * @throws   Exception           If file extension doesn't match
    * @throws   Exception           If error reading the file
    */
    public function loadFile ($file_path, $options = NULL) {
        if ($this->checkFile($file_path)) {
            
            // read uncompressed xlsx contents
            $zip = zip_open($file_path);
            $xml_worksheets = array();
            $xml_sharedstrings = array(); 
            while($zip_entry = zip_read($zip))
            {
                if(preg_match("/xl\/worksheets\/sheet\d+\.xml/", zip_entry_name($zip_entry)))
                {
                    if(zip_entry_open($zip, $zip_entry))
                    {
                        $xml_length = zip_entry_filesize($zip_entry);
                        $xml_read = zip_entry_read($zip_entry, $xml_length);
                        $xml_simplexml = simplexml_load_string($xml_read);
                        $xml_array = (array)$xml_simplexml->children();
                        array_push($xml_worksheets, json_decode(json_encode((array)$xml_array['sheetData']), 1));
                    }
                }
                if(preg_match("/xl\/sharedStrings\.xml/", zip_entry_name($zip_entry)))
                {
                    if(zip_entry_open($zip, $zip_entry))
                    {
                        $xml_length = zip_entry_filesize($zip_entry);
                        $xml_read = zip_entry_read($zip_entry, $xml_length);
                        $xml_simplexml = simplexml_load_string($xml_read);
                        $xml_array = (array)$xml_simplexml->children();
                        $xml_sharedstrings = json_decode(json_encode((array)$xml_array['si']), 1);
                    }
                }
            }
            zip_close($zip);
            
            // map sheets <-> sharedstrings into simpleexcel workbook
            $this->Workbook = new Workbook();
            foreach ($xml_worksheets as $worksheet) {
                $sheet = new Worksheet();
                foreach ($worksheet['row'] as $row) {
                    $record = array();
                    foreach ($row['c'] as $cell) {
                        if (array_key_exists('v', $cell) && array_key_exists($cell['v'], $xml_sharedstrings) && array_key_exists('t', $xml_sharedstrings[$cell['v']])) {
                            array_push($record, new Cell($xml_sharedstrings[$cell['v']]['t']));
                        }
                    }
                    $sheet->insertRecord($record);
                }
                $this->Workbook->insertWorksheet($sheet);
            }
        }
    }
}
