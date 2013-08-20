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
     * Remove a column of data from all records
     *
     * @author  kari.eve.trace@healthplan.com
     * @date    2013-08-15
     * @since   v0.4.0-alpha
     * @param   int $colIndex Column number
     * @todo    Write up unit tests
     */
    public function removeColumn($colIndex) {

        // For each record (row)
        $r_counter = 0;
        foreach($this->records as $r_k => $r_v) {

            // For each column (stack)
            $c_counter = 0;
            foreach ($r_v as $c_k => $c_v) {

                // If the loop counter matches the passed $colIndex
                if ($c_counter == $colIndex) {

                    // Unset that array 
                    unset($this->records[$r_counter][$c_counter]);

                    // Re-apply other array values back to class property
                    $this->records[$r_counter] = array_values($this->records[$r_counter]);
                }

                $c_counter++;
            }
            $r_counter++;
        }


        // Return on completion
        return true;
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
