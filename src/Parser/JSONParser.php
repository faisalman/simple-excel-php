<?php

namespace SimpleExcel\Parser;

use SimpleExcel\Exception\SimpleExcelException;

/**
 * SimpleExcel class for parsing JSON table
 *
 * @author  Faisalman
 * @package SimpleExcel
 */
class JSONParser extends BaseParser implements IParser
{
    /**
    * Defines valid file extension
    *
    * @access   protected
    * @var      string
    */
    protected $file_extension = 'json';

    /**
     * Load the JSON file to be parsed.
     *
     * @param string $filePath Path to JSON file.
     * @return bool
     */
    public function loadFile($filePath)
    {
        if (!$this->isFileReady($filePath)) {
            return;
        }

        $handle = fopen($filePath, 'r');
        $contents = fread($handle, filesize($filePath));
        $this->loadString($contents);
        fclose($handle);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $string String with JSON format.
     * @return bool
     *
     * @throws \Exception If JSON format is invalid (or too deep)
     */
    public function loadString($string)
    {
        $field = array();
        $table = json_decode(utf8_encode($string), false, 4);

        if (null === $table) {
            throw new \Exception(
                sprintf('Invalid JSON format: %s', $string),
                SimpleExcelException::MALFORMED_JSON
            );
        }

        foreach ($table as $rows) {
            $row = array();
            foreach ($rows as $cell) {
                array_push($row, $cell);
            }

            array_push($field, $row);
        }

        $this->table_arr = $field;
    }
}
