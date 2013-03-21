<?php

namespace SimpleExcel\Spreadsheet;

use SimpleExcel\Enums\SimpleExcelException;

/**
 * SimpleExcel class for constructing worksheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */ 
class Worksheet
{
    protected $records;

    public function __construct () {
        $this->records = array();
    }
    
    public function getCell($rowIndex, $colIndex) {
        return $this->records[$rowIndex - 1][$colIndex - 1];
    }
    
    public function getColumn($index) {
        $column = array();
        foreach ($this->records as $row) {
            array_push($column, $row[$index - 1]);
        }
        return $column;
    }
    
    public function getRow($index) {
        return $this->records[$index - 1];
    }
    
    public function getRecords() {
        return $this->records;
    }
    
    public function insertRecord(array $record) {
        $row = array();
        foreach ($record as $cell) {
            if ($cell instanceof Cell) {
                array_push($row, $cell);
            } else {
                array_push($row, new Cell($cell));
            }
        };
        array_push($this->records, $row);
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
