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
     * @param  bool $valOnly Returns (value only or complete data). Default to true [Optional]
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

    /**
     * Get data of all cells as an array.
     *
     * @param  bool $valOnly Returns (value only or complete data) for every cell, default to true [Optional]
     * @return array
     */
    public function getField($valOnly = true);

    /**
     * Check whether cell with specified row & column exists.
     *
     * @param int $rowNum Row number
     * @param int $colNum Column number
     *
     * @return bool
     */
    public function isCellExists($rowNum, $colNum);

    /**
     * Check whether a specified column exists.
     *
     * @param  int $colNum Column number
     * @return bool
     */
    public function isColumnExists($colNum);

    /**
     * Check whether a specified row exists.
     *
     * @param int $rowNum Row number
     * @return bool
     */
    public function isRowExists($rowNum);

    /**
     * Check whether table exists.
     *
     * @return bool
     */
    public function isFieldExists();

    /**
     * Check whether file exists, valid, and readable.
     *
     * @param string $filePath Path to file
     * @return bool
     */
    public function isFileReady($filePath);

    /**
     * Load the file to be parsed.
     *
     * @param string $filePath Path to file.
     * @return bool
     */
    public function loadFile($filePath);

    /**
     * Load the string to be parsed
     *
     * @param string $string String with specified format
     * @return bool
     */
    public function loadString($string);
}
