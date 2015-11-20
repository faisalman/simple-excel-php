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
 * SimpleExcel class for parsing Microsoft Excel TSV Spreadsheet
 *
 * @package SimpleExcel\Parser
 */
class TSVParser extends CSVParser
{
    /**
    * Defines delimiter character (TAB)
    *
    * @access   protected
    * @var      string
    */
    protected $delimiter = "\t";

    /**
    * Defines valid file extension
    *
    * @access   protected
    * @var      string
    */
    protected $file_extension = 'tsv';

    /**
    * Override parent class, this method is ignored in TSV
    */
    public function setDelimiter($delimiter){
        // do nothing
    }
}
