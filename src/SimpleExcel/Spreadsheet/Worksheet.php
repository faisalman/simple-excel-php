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
    /**
    * @access   protected
    * @var      array
    */
    protected $records;

    public function __construct () {
        $this->records = array();
    }
    
    /**
    * Get a specified cell
    * 
    * @param    int     $rowIndex   Row number of specified cell
    * @param    int     $colIndex   Column number of specified cell
    * @return   Cell
    */
    public function getCell($rowIndex, $colIndex) {
        return $this->records[$rowIndex - 1][$colIndex - 1];
    }
    
    /**
    * Get array of cells from a specified column
    * 
    * @param    int     $index      Column number
    * @return   array
    */
    public function getColumn($index) {
        $column = array();
        foreach ($this->records as $row) {
            array_push($column, $row[$index - 1]);
        }
        return $column;
    }
    
    /**
    * Get array of cells from a specified row
    * 
    * @param    int     $index      Row number
    * @return   array
    */
    public function getRow($index) {
        return $this->records[$index - 1];
    }
    
    /**
    * Get all cells
    * 
    * @return   array
    */
    public function getRecords() {
        return $this->records;
    }
    
    /**
    * Insert a record to worksheet
    * 
    * @param    array   $record     Array of cells to be inserted
    */
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
    
    /**
    * Remove specified record from worksheet
    * 
    * @param    int     $index      Row number
    */
    public function removeRecord($index) {        
        array_splice($this->records, $index - 1, 1);
    }
    
    /**
    * Set specified cell value
    * 
    * @param    int     $rowIndex   Row number
    * @param    int     $colIndex   Column number
    * @param    Cell    $cell       New Cell
    */
    public function setCell($rowIndex, $colIndex, Cell $cell) {
        $this->records[$rowIndex - 1][$colIndex - 1] = $cell;
    }
    
    /**
    * Set specified record values
    * 
    * @param    int     $index      Row number
    * @param    array   $record     Record values
    */
    public function setRecord($index, array $record) {
        $this->records[$index - 1] = $record;
    }
    
    /**
    * Set record values all at once
    * 
    * @param    array   $record     Two-dimensional array Cell values
    */
    public function setRecords(array $records) {
        $this->records = $records;
    }
}