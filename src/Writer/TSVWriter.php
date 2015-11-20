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
 * SimpleExcel class for writing TSV Spreadsheet
 *
 * @package SimpleExcel\Writer
 */
class TSVWriter extends CSVWriter implements IWriter
{
    /**
     * Defines content-type for HTTP header
     *
     * @access  protected
     * @var     string
     */
    protected $content_type = 'text/tab-separated-values';

    /**
     * Defines delimiter char
     *
     * @access  protected
     * @var     string
     */
    protected $delimiter = "\t";

    /**
     * Defines file extension to be used when saving file
     *
     * @access  protected
     * @var     string
     */
    protected $file_extension = 'tsv';

    /**
    * Override parent class, this method is ignored in TSV
    */
    public function setDelimiter($delimiter){
        // do nothing
    }
}
?>
