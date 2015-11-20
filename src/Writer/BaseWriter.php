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
 * SimpleExcel base class for writing spreadsheet
 *
 * @package SimpleExcel\Writer
 */
abstract class BaseWriter implements IWriter
{
    /**
     * Holds tabular data
     *
     * @var array
     */
    protected $tabl_data;

    /**
     * Defines content-type for HTTP header
     *
     * @var string
     */
    protected $content_type = 'text';

    /**
     * Defines file extension to be used when saving file
     *
     * @var string
     */
    protected $file_extension = 'txt';

    /**
     * BaseWriter constructor.
     */
    public function __construct()
    {
        $this->tabl_data = array();
    }

    /**
     *{@inheritdoc}
     *
     * @param array $values An array contains ordered value for every cell.
     * @return $this
     */
    public function addRow($values)
    {
        if (!is_array($values)) {
            $values = array($values);
        }

        array_push($this->tabl_data, $values);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function saveString()
    {
        $content = '';

        foreach ($this->tabl_data as $row) {
            foreach ($row as $cell) {
                $content .= $cell.'\t';
            }

            $content .= '\n';
        }

        return $content;
    }

    /**
     * {@inheritdoc}
     *
     * @param string $fileName Name for the saved file
     * @param string $target   Save location (or write output to browser) [Optional]
     * @return $this
     */
    public function saveFile($fileName, $target)
    {
        if (!isset($fileName)) {
            $fileName = date('YmdHis');
        }

        if (empty($target)) {
            $target = 'php://output';

            header('Content-Type: '.$this->content_type);
            header('Content-Disposition: attachment; filename='.$fileName.'.'.$this->file_extension);
        }

        $fp = fopen($target, 'w');
        fwrite($fp, $this->saveString());
        fclose($fp);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param array $values An array contains ordered value of arrays for all fields
     * @return $this
     */
    public function setData($values)
    {
        if (!is_array($values)) {
            $values = array($values);
        }

        $this->tabl_data = $values;

        return $this;
    }
}
