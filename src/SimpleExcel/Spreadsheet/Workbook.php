<?php

namespace SimpleExcel\Spreadsheet;

use SimpleExcel\Exception\SimpleExcelException;

/**
 * SimpleExcel class for constructing workbook
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */ 
class Workbook implements IWorkbook
{
    protected $worksheets;
    
    public function __construct () {
        $this->worksheets = array();
    }
    
    public function getWorksheet($index) {
        if (!isset($this->worksheets[$index])) {
            throw new \Exception('Worksheet ' . $index . ' not found', SimpleExcelException::WORKSHEET_NOT_FOUND);
        } else {
            return $this->worksheets[$index];
        }
    }
    
    public function insertWorksheet(Worksheet $worksheet) {
        array_push($this->worksheets, $worksheet);
    }

    public function removeWorksheet($index) {
        $this->worksheets[$index] = NULL;
    }
}
