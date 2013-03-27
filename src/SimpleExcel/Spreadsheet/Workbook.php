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
    /**
    * Array of worksheets
    * 
    * @access   protected
    * @var      array
    */
    protected $worksheets;
    
    public function __construct () {
        $this->worksheets = array();
    }
    
    /**
    * Get specified worksheet by index
    * 
    * @param    int     $index      Worksheet index
    * @return   Worksheet
    */
    public function getWorksheet ($index) {
        if (!isset($this->worksheets[$index - 1])) {
            throw new \Exception('Worksheet ' . $index . ' is not found', SimpleExcelException::WORKSHEET_NOT_FOUND);
        } else {
            return $this->worksheets[$index - 1];
        }
    }
    
    /**
    * Get all worksheets
    * 
    * @return   array
    */
    public function getWorksheets () {
        return $this->worksheets;
    }
    
    /**
    * Insert a new worksheet
    * 
    * @param    Worksheet   $worksheet  Worksheet to be inserted
    */
    public function insertWorksheet (Worksheet $worksheet = NULL) {
        $worksheet = ($worksheet == NULL) ? new Worksheet() : $worksheet;
        array_push($this->worksheets, $worksheet);
    }

    /**
    * Remove a worksheet from workbook
    * 
    * @param    int     $index  Worksheet index to be removed
    */
    public function removeWorksheet ($index) {
        array_splice($this->worksheets, $index - 1, 1);
    }
}
