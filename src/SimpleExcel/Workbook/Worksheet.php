<?php

namespace SimpleExcel\Spreadsheet;

use SimpleExcel\Exception\SimpleExcelException;

/**
 * SimpleExcel class for constructing worksheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */ 
class Worksheet implements IWorksheet
{    
    public function getCell($rowIndex, $colIndex) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    
    public function getColumn($index) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    
    public function getRow($index) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    
    public function getRecords() {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    
    public function insertRecord(array $record) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    
    public function removeRecord($index) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    
    public function setRecord($index, array $record) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    
    public function setRecords(array $records) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
}
