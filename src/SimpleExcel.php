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

namespace SimpleExcel;

use SimpleExcel\Exception\SimpleExcelException;

use SimpleExcel\Parser\CSVParser;
use SimpleExcel\Parser\XMLParser;
use SimpleExcel\Parser\TSVParser;
use SimpleExcel\Parser\HTMLParser;
use SimpleExcel\Parser\JSONParser;
use SimpleExcel\Writer\CSVWriter;
use SimpleExcel\Writer\TSVWriter;
use SimpleExcel\Writer\XMLWriter;
use SimpleExcel\Writer\HTMLWriter;
use SimpleExcel\Writer\JSONWriter;

/**
 * SimpleExcel main class
 *
 * @package SimpleExcel
 */
class SimpleExcel
{
    /**
     * Parser object
     * @var CSVParser | TSVParser | XMLParser | HTMLParser | JSONParser
     */
    public $parser;

    /**
     * Writer object
     * @var CSVWriter | TSVWriter | XMLWriter | HTMLWriter | JSONWriter
     */
    public $writer;

    /**
     * The valid Parser types
     * @var array
     */
    protected $validParserTypes = array('XML', 'CSV', 'TSV', 'HTML', 'JSON');

    /**
     * The valid Writer types
     * @var array
     */
    protected $validWriterTypes = array('XML', 'CSV', 'TSV', 'HTML', 'JSON');

    /**
     * SimpleExcel constructor.
     *
     * @param string $filetype Set the filetype of the file which will be parsed (XML/CSV/TSV/HTML/JSON)
     */
    public function __construct($filetype = 'XML')
    {
        $this->constructParser($filetype);
        $this->constructWriter($filetype);
    }

    /**
     * Construct a SimpleExcel Parser
     *
     * @param string $filetype Set the filetype of the file which will be parsed (XML/CSV/TSV/HTML/JSON)
     * @return $this
     *
     * @throws \Exception If filetype is neither XML/CSV/TSV/HTML/JSON
     */
    public function constructParser($filetype)
    {
        $filetype = strtoupper($filetype);

        if (!in_array($filetype, $this->validParserTypes)) {
            throw new \Exception(
                sprintf('Filetype %s is not supported', $filetype),
                SimpleExcelException::FILETYPE_NOT_SUPPORTED
            );
        }

        $parserClass = 'SimpleExcel\\Parser\\'.$filetype.'Parser';
        $this->parser = new $parserClass();

        return $this;
    }

    /**
     * Construct a SimpleExcel Writer
     *
     * @param string $filetype Set the filetype of the file which will be written (XML/CSV/TSV/HTML/JSON)
     * @return $this
     *
     * @throws \Exception If filetype is neither XML/CSV/TSV/HTML/JSON
     */
    public function constructWriter($filetype)
    {
        $filetype = strtoupper($filetype);

        if (!in_array($filetype, $this->validWriterTypes)) {
            throw new \Exception(
                sprintf('Filetype %s is not supported', $filetype),
                SimpleExcelException::FILETYPE_NOT_SUPPORTED
            );
        }

        $writerClass = 'SimpleExcel\\Writer\\'.$filetype.'Writer';
        $this->writer = new $writerClass();

        return $this;
    }

    /**
     * Change writer type to convert to another format
     *
     * @param string $filetype Set the filetype of the file which will be written (XML/CSV/TSV/HTML/JSON)
     * @return $this
     */
    public function convertTo($filetype)
    {
        $this->constructWriter($filetype);
        $this->writer->setData($this->parser->getField());

        return $this;
    }
}
