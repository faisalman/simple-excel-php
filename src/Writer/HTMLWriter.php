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
 * SimpleExcel class for writing HTML table
 *
 * @package SimpleExcel\Writer
 */
class HTMLWriter extends BaseWriter implements IWriter
{
    /**
     * Defines content-type for HTTP header
     *
     * @var string
     */
    protected $content_type = 'text/html';

    /**
     * Defines file extension to be used when saving file
     *
     * @var string
     */
    protected $file_extension = 'html';

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function saveString()
    {
        $content = '<table>';

        foreach ($this->tabl_data as $row) {
            $content .= '<tr>';

            foreach ($row as $cell) {
                $content .= sprintf('<td>%s</td>', $cell);
            }

            $content .= '</tr>';
        }

        $content .= '</table>';

        return $content;
    }
}
