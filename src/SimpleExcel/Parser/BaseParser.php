<?php

namespace SimpleExcel\Parser;

use SimpleExcel\Exception\SimpleExcelException;

/**
 * Base BaseParser class
 *
 * @author  Faisalman
 * @package SimpleExcel\Parser
 */
abstract class BaseParser implements IParser
{
    /**
     * Holds the parsed result
     *
     * @var array
     */
    protected $table_arr;

    /**
     * Defines valid file extension
     *
     * @var string
     */
    protected $file_extension = '';

    /**
     * @param    string  $file_url   Path to file (optional)
     */
    public function __construct($file_url = null) {
        if (isset($file_url)) {
            $this->loadFile($file_url);
        }
    }

    /**
     * Get value of the specified cell
     *
     * @param  int $row_num Row number
     * @param  int $col_num Column number
     * @param  int $val_only
     * @return array
     *
     * @throws \Exception If the cell identified doesn't exist.
     */
    public function getCell($row_num, $col_num, $val_only)
    {
        if (!$this->isCellExists($row_num, $col_num)) {
            throw new \Exception(
                sprintf(
                    "Cell %s,%s doesn't exist",
                    $row_num,
                    $col_num
                ),
                SimpleExcelException::CELL_NOT_FOUND
            );
        }

        return $this->table_arr[$row_num-1][$col_num-1];
    }

    /**
     * Get data of the specified column as an array
     *
     * @param int  $col_num Column number
     * @param bool $val_only
     *
     * @return array
     *
     * @throws \Exception If the column requested doesn't exist.
     */
    public function getColumn($col_num, $val_only)
    {
        $col_arr = array();

        if (!$this->isColumnExists($col_num)) {
            throw new \Exception(
                sprintf(
                    "Column %s doesn't exist",
                    $col_num
                ),
                SimpleExcelException::COLUMN_NOT_FOUND
            );
        }

        // get the specified column within every row
        foreach ($this->table_arr as $row) {
            array_push($col_arr, $row[$col_num-1]);
        }

        return $col_arr;
    }

    /**
     * Get data of all cells as an array
     *
     * @param  bool $val_only
     * @return array
     *
     * @throws \Exception If the field is not set.
     */
    public function getField($val_only)
    {
        if (!$this->isFieldExists()) {
            throw new \Exception('Field is not set', SimpleExcelException::FIELD_NOT_FOUND);
        }

        return $this->table_arr;
    }

    /**
     * Get data of the specified row as an array.
     *
     * @param int $row_num Row number
     * @param bool $val_only
     * @return array
     *
     * @throws \Exception When a row is requested that doesn't exist.
     */
    public function getRow($row_num, $val_only)
    {
        if (!$this->isRowExists($row_num)) {
            throw new \Exception(
                sprintf(
                    "Row %s doesn't exist",
                    $row_num
                ),
                SimpleExcelException::ROW_NOT_FOUND
            );
        }

        return $this->table_arr[$row_num-1];
    }

    /**
     * Check whether cell with specified row & column exists.
     *
     * @param int $row_num Row number
     * @param int $col_num Column number
     *
     * @return bool
     */
    public function isCellExists($row_num, $col_num)
    {
        return $this->isRowExists($row_num) && $this->isColumnExists($col_num);
    }

    /**
     * Check whether a specified column exists
     *
     * @param  int $col_num Column number
     * @return bool
     */
    public function isColumnExists($col_num)
    {
        $exist = false;

        foreach ($this->table_arr as $row) {
            if (array_key_exists($col_num-1, $row)) {
                $exist = true;
            }
        }

        return $exist;
    }

    /**
     * Check whether a specified row exists
     *
     * @param int $row_num Row number
     * @return bool
     */
    public function isRowExists($row_num)
    {
        return array_key_exists($row_num-1, $this->table_arr);
    }

    /**
     * Check whether table exists
     *
     * @return bool
     */
    public function isFieldExists()
    {
        return isset($this->table_arr);
    }

    /**
     * Check whether file exists, valid, and readable.
     *
     * @param string $file_path  Path to file
     * @return bool
     *
     * @throws \Exception If file being loaded doesn't exist
     * @throws \Exception If file extension doesn't match
     * @throws \Exception If error reading the file
     */
    public function isFileReady($file_path)
    {
        if (!file_exists($file_path)) {
            throw new \Exception(
                sprintf("File %s doesn't exist", $file_path),
                SimpleExcelException::FILE_NOT_FOUND
            );
        } elseif (strtoupper(pathinfo($file_path, PATHINFO_EXTENSION))!= strtoupper($this->file_extension)){
            throw new \Exception(
                sprintf(
                    "File extension %s doesn't match with %s",
                    $this->file_extension,
                    $this->file_extension
                ),
                SimpleExcelException::FILE_EXTENSION_MISMATCH
            );
        } elseif (false === ($handle = fopen($file_path, 'r'))) {
            fclose($handle);
            throw new \Exception(
                sprintf('Error reading the file from %s', $file_path),
                SimpleExcelException::ERROR_READING_FILE
            );
        }

        return true;
    }
}
