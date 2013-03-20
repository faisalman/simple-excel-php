<?php

namespace SimpleExcel\Spreadsheet;

use SimpleExcel\Datatype\SimpleExcelDatatype;
use SimpleExcel\Exception\SimpleExcelException;

/**
 * SimpleExcel class for cell
 * 
 * @author  Faisalman
 * @package SimpleExcel
 */ 
class Cell
{
    /**
    * Cell datatype
    * 
    * @access   public
    * @var      int
    */
    public $datatype;

    /**
    * Cell value
    * 
    * @access   public
    * @var      mixed
    */
    public $value;
    
    /**
    * @param    mixed  $value       Cell value
    * @param    string  $datatype   Cell type (optional)
    */
    public function __construct($value = '', $datatype = SimpleExcelDatatype::TEXT) {
        $this->value = $value;
        $this->datatype = $datatype;
    }
}