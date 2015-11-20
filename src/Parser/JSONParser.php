<?php

/*
 +------------------------------------------------------------------------+
 | The SimpleExcel Component                                              |
 +------------------------------------------------------------------------+
 | Copyright © 2011-2013 Faisalman <fyzlman@gmail.com>                    |
 | Copyright © 2015 (c) Serghei Iakovlev <me@klay.me>                     |
 +------------------------------------------------------------------------+
 | This source file is subject to the MIT License that is bundled         |
 | with this package in the file LICENSE.md.                              |
 |                                                                        |
 | If you did not receive a copy of the license and are unable to         |
 | obtain it through the world-wide-web, please send an email             |
 | to me@klay.me so I can send you a copy immediately.                    |
 +------------------------------------------------------------------------+
*/

namespace SimpleExcel\Parser;

use SimpleExcel\Exception\SimpleExcelException;

/**
 * SimpleExcel class for parsing JSON table
 *
 * @package SimpleExcel\Parser
 */
class JSONParser extends BaseParser implements IParser
{
    /**
    * Defines valid file extension
    *
    * @var string
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
