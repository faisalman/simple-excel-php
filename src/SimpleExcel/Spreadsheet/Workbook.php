<?php

namespace SimpleExcel\Spreadsheet;

use SimpleExcel\Enums\SimpleExcelException;

/**
 * SimpleExcel class for constructing workbook
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */ 
class Workbook
{
    protected $worksheets;
    
    public function __construct () {
        $this->worksheets = array();
    }
    
    public function getWorksheet ($index) {
        if (!isset($this->worksheets[$index - 1])) {
            throw new \Exception('Worksheet ' . $index . ' is not found', SimpleExcelException::WORKSHEET_NOT_FOUND);
        } else {
            return $this->worksheets[$index - 1];
        }
    }
    
    public function getWorksheets () {
        return $this->worksheets;
    }
    
    public function insertWorksheet (Worksheet $worksheet) {
        array_push($this->worksheets, $worksheet);
    }

    public function removeWorksheet ($index) {
        $this->worksheets[$index - 1] = NULL;
    }
}
