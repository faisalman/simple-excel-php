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

/**
 * SimpleExcel class for parsing Microsoft Excel XLSX Spreadsheet
 *
 * @package SimpleExcel\Parser
 */
class XLSXParser extends BaseParser implements IParser
{
    /**
    * Defines valid file extension
    *
    * @access   protected
    * @var      string
    */
    protected $file_extension = 'xlsx';

    /**
     * {@inheritdoc}
     *
     * @param string $filePath Path to XLSX file.
     * @return bool
     *
     * @throws \Exception
     */
    public function loadFile($filePath)
    {
        throw new \Exception('Not Implemented yet');
    }

    /**
     * {@inheritdoc}
     *
     * @param string $string String with XML format.
     * @return bool
     *
     * @throws \Exception
     */
    public function loadString($string)
    {
        throw new \Exception('Not Implemented yet');
    }
}
