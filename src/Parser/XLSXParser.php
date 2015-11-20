<?php

namespace SimpleExcel\Parser;

/**
 * SimpleExcel class for parsing Microsoft Excel XLSX Spreadsheet
 *
 * @author  Faisalman
 * @package SimpleExcel
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
