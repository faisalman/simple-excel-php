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
    * Get count of columns
    * 
    * @return   integer
    */
    public function getColumns() {
        return count($this->records[0]);
    }

    /**
    * Get array of cells from a specified row
    * 
    * @param    int     $index      Row number
    * @return   array
    */
    public function getRecord($index) {
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
    * Add new column, vertical dataset 
    *
    * @author   kari.eve.trace@gmail.com
    * @date     2013-09-13
    * @since    0.4.0-5811690c
    * @version  0.4.1
    * @param    string      $colData    Data to fill the column with
    * @param    integer     $rowCount   Number of rows to add the new column to
    */
    public function insertColumn(array $colData, $rowCount = null) {

        // Set col and row counts
        $colCount = count($this->getRecord(1));

        // Ensure rowCount is numeric if it is passed int
        if (isset($rowCount) && !is_numeric($rowCount)) {return false;}
        $rowCount = (!$rowCount) ? count($this->records) : $rowCount;



        // Iterate for each new column to be added
        foreach ($colData as $c_k => $c_v) {

            // Iterate over each record in data set
            for ($i = 1; $i <= $rowCount; $i++) {

                // Set the value of the new cell based on iteration value
                $cell_data = null;

                // not the first row? Set to 0
                if ($i != 1) {
                    $cell_data = new Cell(0, 0);
                // ...is the first row? Set to title
                } elseif ($i == 1) {
                    $cell_data = new Cell($c_v, 0);
                // ...any other options? set to null.
                } else {
                    $cell_data = new Cell(null, 0);
                }

                $this->setCell($i, $colCount+1, $cell_data);
            }
        }

        return true;
    }

    /**
    * Insert a record to worksheet, horizontal dataset.
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
    * @author  kari.eve.trace@gmail.com
    * @date    2013-08-15
    * @since   v0.4.0-alpha
    * @param   int     $colIndex   Column number  
    */
    public function removeColumn($colIndex) {

        // Ensure method param is an positive 
        if (!is_numeric($colIndex) || $colIndex <= 0) {
            return false;
        }



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
