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

/**
 * SimpleExcel main class
 *
 * @package SimpleExcel
 */
class SimpleExcel
{
    /**
    *
    * @var CSVParser | TSVParser | XMLParser | HTMLParser | JSONParser
    */
    public $parser;

    /**
    *
    * @var CSVWriter | TSVWriter | XMLWriter | HTMLWriter | JSONWriter
    */
    public $writer;

    /**
    *
    * @var array
    */
    protected $validParserTypes = array('XML', 'CSV', 'TSV', 'HTML', 'JSON');
    protected $validWriterTypes = array('XML', 'CSV', 'TSV', 'HTML', 'JSON');

    /**
    * SimpleExcel constructor method
    *
    * @param    string  $filetype   Set the filetype of the file which will be parsed (XML/CSV/TSV/HTML/JSON)
    * @return   void
    */
    public function __construct($filetype = 'XML'){
        $this->constructParser($filetype);
        $this->constructWriter($filetype);
    }

    /**
    * Construct a SimpleExcel Parser
    *
    * @param    string  $filetype   Set the filetype of the file which will be parsed (XML/CSV/TSV/HTML/JSON)
    * @throws   Exception           If filetype is neither XML/CSV/TSV/HTML/JSON
    */
    public function constructParser($filetype){
        $filetype = strtoupper($filetype);
        if(!in_array($filetype, $this->validParserTypes)){
            throw new \Exception('Filetype '.$filetype.' is not supported', SimpleExcelException::FILETYPE_NOT_SUPPORTED);
        }
        $parser_class = 'SimpleExcel\\Parser\\'.$filetype.'Parser';
        $this->parser = new $parser_class();
    }

    /**
    * Construct a SimpleExcel Writer
    *
    * @param    string  $filetype   Set the filetype of the file which will be written (XML/CSV/TSV/HTML/JSON)
    * @return   bool
    * @throws   Exception           If filetype is neither XML/CSV/TSV/HTML/JSON
    */
    public function constructWriter($filetype){
        $filetype = strtoupper($filetype);

        if(!in_array($filetype, $this->validWriterTypes)){
            throw new \Exception('Filetype '.$filetype.' is not supported', SimpleExcelException::FILETYPE_NOT_SUPPORTED);
        }
        $writer_class = 'SimpleExcel\\Writer\\'.$filetype.'Writer';
        $this->writer = new $writer_class();
    }

    /**
    * Change writer type to convert to another format
    *
    * @param    string  $filetype   Set the filetype of the file which will be written (XML/CSV/TSV/HTML/JSON)
    */
    public function convertTo($filetype){
        $this->constructWriter($filetype);
        $this->writer->setData($this->parser->getField());
    }

    /**
     * Autoloader
     *
     * @param   string   $class_name The class we want to load
     */
    public static function autoLoader($class_name){
        if($class_name != 'SimpleExcel') require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, substr($class_name, strlen('SimpleExcel\\'))).'.php');
    }
}
