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
    * @var      SimpleExcelDatatype
    */
    public $datatype = SimpleExcelDatatype::TEXT;

    /**
    * Cell value
    * 
    * @access   public
    * @var      string
    */
    public $value = '';
}
