<?php

namespace SimpleExcel\Spreadsheet;

/**
 * Defines SimpleExcel workbook interface
 * 
 * @author  Faisalman
 * @package SimpleExcel
 */

/** define workbook interface */
interface IWorkbook
{
    public function getWorksheet($index);
    public function getWorksheets();
    public function insertWorksheet(Worksheet $worksheet);
    public function removeWorksheet($index);
    public function setWorksheet($index, Worksheet $worksheet);
    public function setWorksheets(array $worksheets);
}
