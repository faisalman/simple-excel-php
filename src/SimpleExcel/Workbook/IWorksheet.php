<?php

namespace SimpleExcel\Spreadsheet;

/**
 * Defines SimpleExcel worksheet interface
 * 
 * @author  Faisalman
 * @package SimpleExcel
 */

/** define worksheet interface */
interface IWorksheet
{
    public function getCell($rowIndex, $colIndex);
    public function getColumn($index);
    public function getRow($index);
    public function getRecords();
    public function insertRecord(array $record);
    public function removeRecord($index);
    public function setRecord($index, array $record);
    public function setRecords(array $records);
}
