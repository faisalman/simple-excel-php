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
    protected $records;

    public function __construct () {
        $this->records = array();
    }
    
    public function getCell($rowIndex, $colIndex) {
        return $this->records[$rowIndex - 1][$colIndex - 1];
    }
    
    public function getColumn($index) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    
    public function getRow($index) {
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    
    public function getRecords() {
        return $this->records;
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
        $this->records = $records;
    }
}
