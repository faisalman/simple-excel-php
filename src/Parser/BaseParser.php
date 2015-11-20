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
     * {@inheritdoc}
     *
     * @param  int  $rowNum  Row number
     * @param  int  $colNum  Column number
     * @param  bool $valOnly Returns (value only or complete data) for every cell, default to true [Optional]
     * @return array
     *
     * @throws \Exception If the cell identified doesn't exist.
     */
    public function getCell($rowNum, $colNum, $valOnly = true)
    {
        if (!$this->isCellExists($rowNum, $colNum)) {
            throw new \Exception(
                sprintf(
                    "Cell %s,%s doesn't exist",
                    $rowNum,
                    $colNum
                ),
                SimpleExcelException::CELL_NOT_FOUND
            );
        }

        return $this->table_arr[$rowNum - 1][$colNum - 1];
    }

    /**
     * {@inheritdoc}
     *
     * @param int  $colNum  Column number
     * @param bool $valOnly Returns (value only or complete data) for every cell, default to true [Optional]
     *
     * @return array
     *
     * @throws \Exception If the column requested doesn't exist.
     */
    public function getColumn($colNum, $valOnly = true)
    {
        $colArr = array();

        if (!$this->isColumnExists($colNum)) {
            throw new \Exception(
                sprintf(
                    "Column %s doesn't exist",
                    $colNum
                ),
                SimpleExcelException::COLUMN_NOT_FOUND
            );
        }

        foreach ($this->table_arr as $row) {
            array_push($colArr, $row[$colNum - 1]);
        }

        return $colArr;
    }

    /**
     * {@inheritdoc}
     *
     * @param  bool $valOnly Returns (value only or complete data). Default to true [Optional]
     * @return array
     *
     * @throws \Exception If the field is not set.
     */
    public function getField($valOnly = true)
    {
        if (!$this->isFieldExists()) {
            throw new \Exception('Field is not set', SimpleExcelException::FIELD_NOT_FOUND);
        }

        return $this->table_arr;
    }

    /**
     * {@inheritdoc}
     *
     * @param int $rowNum   Row number
     * @param bool $valOnly Returns (value only or complete data) for every cell, default to true [Optional]
     * @return array
     *
     * @throws \Exception When a row is requested that doesn't exist.
     */
    public function getRow($rowNum, $valOnly = true)
    {
        if (!$this->isRowExists($rowNum)) {
            throw new \Exception(
                sprintf("Row %s doesn't exist", $rowNum),
                SimpleExcelException::ROW_NOT_FOUND
            );
        }

        return $this->table_arr[$rowNum - 1];
    }

    /**
     * {@inheritdoc}
     *
     * @param int $rowNum Row number
     * @param int $colNum Column number
     *
     * @return bool
     */
    public function isCellExists($rowNum, $colNum)
    {
        return $this->isRowExists($rowNum) && $this->isColumnExists($colNum);
    }

    /**
     * {@inheritdoc}
     *
     * @param  int $colNum Column number
     * @return bool
     */
    public function isColumnExists($colNum)
    {
        $exist = false;

        foreach ($this->table_arr as $row) {
            if (array_key_exists($colNum - 1, $row)) {
                $exist = true;
            }
        }

        return $exist;
    }

    /**
     * {@inheritdoc}
     *
     * @param int $rowNum Row number
     * @return bool
     */
    public function isRowExists($rowNum)
    {
        return array_key_exists($rowNum - 1, $this->table_arr);
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function isFieldExists()
    {
        return isset($this->table_arr);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $filePath Path to file
     * @return bool
     *
     * @throws \Exception If file being loaded doesn't exist
     * @throws \Exception If file extension doesn't match
     * @throws \Exception If error reading the file
     */
    public function isFileReady($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \Exception(
                sprintf("File %s doesn't exist", $filePath),
                SimpleExcelException::FILE_NOT_FOUND
            );
        } elseif (strtoupper(pathinfo($filePath, PATHINFO_EXTENSION))!= strtoupper($this->file_extension)){
            throw new \Exception(
                sprintf(
                    "File extension %s doesn't match with %s",
                    $this->file_extension,
                    $this->file_extension
                ),
                SimpleExcelException::FILE_EXTENSION_MISMATCH
            );
        } elseif (false === ($handle = fopen($filePath, 'r'))) {
            fclose($handle);
            throw new \Exception(
                sprintf('Error reading the file from %s', $filePath),
                SimpleExcelException::ERROR_READING_FILE
            );
        }

        return true;
    }
}
