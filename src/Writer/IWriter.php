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

namespace SimpleExcel\Writer;

/**
 * Defines SimpleExcel writer interface
 *
 * @package SimpleExcel\Writer
 */
interface IWriter
{
    /**
     * Adding row data to table.
     *
     * @param array $values An array contains ordered value for every cell.
     * @return IWriter
     */
    public function addRow($values);

    /**
     * Get document content as string.
     *
     * @return string
     */
    public function saveString();

    /**
     * Export the document.
     *
     * @param string $fileName Name for the saved file
     * @param string $target   Save location (or write output to browser) [Optional]
     * @return IWriter
     */
    public function saveFile($fileName, $target);

    /**
     * Set tabular data.
     *
     * @param array $values An array contains ordered value of arrays for all fields
     * @return IWriter
     */
    public function setData($values);
}
