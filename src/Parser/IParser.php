<?php

namespace SimpleExcel\Parser;

/**
 * Defines SimpleExcel parser interface
 *
 * @package SimpleExcel\Parser
 */
interface IParser
{
    /**
     * Get value of the specified cell.
     *
     * @param  int  $rowNum  Row number
     * @param  int  $colNum  Column number
     * @param  bool $valOnly Returns (value only or complete data) for every cell, default to true [Optional]
     * @return array
     */
    public function getCell($rowNum, $colNum, $valOnly = true);

    /**
     * Get data of the specified column as an array.
     *
     * @param int  $colNum  Column number
     * @param bool $valOnly Returns (value only or complete data) for every cell, default to true [Optional]
     *
     * @return array
     */
    public function getColumn($colNum, $valOnly = true);

    /**
     * Get data of the specified row as an array.
     *
     * @param int $rowNum   Row number
     * @param bool $valOnly Returns (value only or complete data) for every cell, default to true [Optional]
     * @return array
     */
    public function getRow($rowNum, $valOnly = true);

    public function getField($val_only);
    public function isCellExists($row_num, $col_num);
    public function isColumnExists($col_num);
    public function isRowExists($row_num);
    public function isFieldExists();
    public function isFileReady($file_path);
    public function loadFile($file_path);
    public function loadString($str);
}
