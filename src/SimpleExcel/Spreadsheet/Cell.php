<?php

namespace SimpleExcel\Spreadsheet;

use SimpleExcel\Enums\Datatype;
use SimpleExcel\Enums\SimpleExcelException;

/**
 * SimpleExcel struct for cell
 * 
 * @author  Faisalman
 * @package SimpleExcel
 */

/** define cell struct */
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
    public function __construct($value = '', $datatype = Datatype::TEXT) {
        $this->value = $value;
        $this->datatype = $datatype;
    }
}
