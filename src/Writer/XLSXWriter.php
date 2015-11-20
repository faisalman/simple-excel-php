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
 * SimpleExcel class for writing Microsoft Excel XLSX Spreadsheet
 *
 * @package SimpleExcel\Writer
 */
class XLSXWriter extends BaseWriter implements IWriter
{
    /**
     * Defines content-type for HTTP header
     *
     * @var string
     */
    protected $content_type = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

    /**
     * Defines file extension to be used when saving file
     *
     * @var string
     */
    protected $file_extension = 'xlsx';

    /**
     * Array containing document properties
     *
     * @var array
     */
    private $doc_prop;

    /**
     * Adding row data to XLSX.
     *
     * @param array $values An array contains ordered value for every cell.
     * @return $this
     *
     * @throws \Exception
     */
    public function addRow($values)
    {
        throw new \Exception('Not implemented yet');
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     *
     * @throws \Exception
     */
    public function saveString()
    {
        throw new \Exception('Not implemented yet');
    }

    /**
     * Set XLSX data
     *
     * @param array $values An array contains ordered value of arrays for all fields
     * @return $this
     *
     * @throws \Exception
     */
    public function setData($values)
    {
        throw new \Exception('Not implemented yet');
    }

    /**
    * Set a document property of the XLSX.
    *
    * @param string $prop Document property to be set
    * @param string $val  Value of the document property
    * @return $this
    */
    public function setDocProp($prop, $val)
    {
        $this->doc_prop[$prop] = $val;

        return $this;
    }
}
