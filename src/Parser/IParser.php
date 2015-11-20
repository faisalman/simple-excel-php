<?php
 
namespace SimpleExcel\Parser;

/**
 * Defines SimpleExcel parser interface
 * 
 * @author  Faisalman
 * @package SimpleExcel
 */

/** define parser interface */
interface IParser
{
    public function getCell($row_num, $col_num, $val_only);
    public function getColumn($col_num, $val_only);
    public function getRow($row_num, $val_only);
    public function getField($val_only);
    public function isCellExists($row_num, $col_num);
    public function isColumnExists($col_num);
    public function isRowExists($row_num);
    public function isFieldExists();
    public function isFileReady($file_path);
    public function loadFile($file_path);
    public function loadString($str);
}

?>
