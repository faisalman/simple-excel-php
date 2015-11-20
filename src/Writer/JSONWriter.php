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
 * SimpleExcel class for writing table as JSON
 *
 * @package SimpleExcel\Writer
 */
class JSONWriter extends BaseWriter implements IWriter
{
    /**
     * Defines content-type for HTTP header
     *
     * @var string
     */
    protected $content_type = 'application/json';

    /**
     * Defines file extension to be used when saving file
     *
     * @var string
     */
    protected $file_extension = 'json';

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function saveString()
    {
        $json = array();

        foreach ($this->tabl_data as $row) {
            $row_array = array();

            for ($i = 0; $i < count($row); $i++) {
                $row_array[$i] = $row[$i];
            }

            array_push($json, (object)$row);
        }

        return json_encode($json);
    }
}
