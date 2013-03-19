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
    public function getWorksheet($index) {
        throw new \Exception('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    
    public function getWorksheets() {
        throw new \Exception('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    
    public function insertWorksheet(Worksheet $worksheet) {
        throw new \Exception('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    
    public function removeWorksheet($index) {
        throw new \Exception('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    
    public function setWorksheet($index, Worksheet $worksheet) {
        throw new \Exception('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    
    public function setWorksheets(array $worksheets) {
        throw new \Exception('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
}
