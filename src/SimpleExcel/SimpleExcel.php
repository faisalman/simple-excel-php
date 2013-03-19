<?php
/**
 * Simple Excel
 * 
 * A PHP library with simplistic approach
 * Easily parse/convert/write between Microsoft Excel XML/CSV/TSV/HTML/JSON/etc formats
 *  
 * Copyright (c) 2011-2013 Faisalman <fyzlman@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * @author      Faisalman
 * @copyright   2011-2013 (c) Faisalman
 * @license     http://www.opensource.org/licenses/mit-license
 * @link        http://github.com/faisalman/simple-excel-php
 * @package     SimpleExcel
 * @version     0.4.0
 */

namespace SimpleExcel;

use SimpleExcel\Exception\SimpleExcelException;
use SimpleExcel\Spreadsheet\Workbook;

if (!class_exists('Composer\\Autoload\\ClassLoader', false)){
    // autoload all interfaces & classes
    spl_autoload_register(function($class_name){
        if($class_name != 'SimpleExcel') require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, substr($class_name, strlen('SimpleExcel\\'))).'.php');
    });
}

/**
 * SimpleExcel main class
 * 
 * @author Faisalman
 * @package SimpleExcel
 */
class SimpleExcel
{
    /**
    * 
    * @var Workbook
    */
    public $workbook;

    /**
    * 
    * @var IParser
    */
    public $parser;

    /**
    * 
    * @var IWriter
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
    public function __construct($filetype = NULL){
        $this->workbook = new Workbook();
        if (isset($filetype)) {
            $this->setParserType($filetype);
            $this->setWriterType($filetype);
        }
    }

    /**
    * Construct a SimpleExcel Parser
    * 
    * @param    string  $filetype   Set the filetype of the file which will be parsed (XML/CSV/TSV/HTML/JSON)
    * @throws   Exception           If filetype is neither XML/CSV/TSV/HTML/JSON
    */
    public function setParserType($filetype){
        $filetype = strtoupper($filetype);
        if(!in_array($filetype, $this->validParserTypes)){
            throw new \Exception('Filetype '.$filetype.' is not supported', SimpleExcelException::FILETYPE_NOT_SUPPORTED);
        }
        $parser_class = 'SimpleExcel\\Parser\\'.$filetype.'Parser';
        $this->parser = new $parser_class($this->workbook);
    }

    /**
    * Construct a SimpleExcel Writer
    * 
    * @param    string  $filetype   Set the filetype of the file which will be written (XML/CSV/TSV/HTML/JSON)
    * @return   bool
    * @throws   Exception           If filetype is neither XML/CSV/TSV/HTML/JSON
    */
    public function setWriterType($filetype){
        $filetype = strtoupper($filetype);

        if(!in_array($filetype, $this->validWriterTypes)){
            throw new \Exception('Filetype '.$filetype.' is not supported', SimpleExcelException::FILETYPE_NOT_SUPPORTED);
        }
        $writer_class = 'SimpleExcel\\Writer\\'.$filetype.'Writer';
        $this->writer = new $writer_class($this->workbook);
    }

    /**
    * @deprecated since v0.4
    */
    public function constructParser($filetype){
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    public function constructWriter($filetype){
        throw new \BadMethodCallException('Unimplemented method', SimpleExcelException::UNIMPLEMENTED_METHOD);
    }
    public function convertTo($filetype){
        throw new \BadMethodCallException('Deprecated method', SimpleExcelException::DEPRECATED_METHOD);
    }
}
