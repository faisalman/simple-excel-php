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
 * @version     0.4.0-beta
 */

namespace SimpleExcel;

use SimpleExcel\Enums\SimpleExcelException;
use SimpleExcel\Spreadsheet\Workbook;
use SimpleExcel\Spreadsheet\Worksheet;

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
    * @var IParser
    */
    protected $parser;
    
    /**
    * @var string
    */
    protected $parserType;

    /**
    * @var array
    */
    protected $validParserTypes;
    
    /**
    * @var array
    */
    protected $validWriterTypes;
    
    /**
    * @var IWriter
    */
    protected $writer;
    
    /**
    * @var string
    */
    protected $writerType;
    
    /**
    * @var Workbook
    */
    public $workbook;

    /**
    * SimpleExcel constructor method
    * 
    * @param    string  $filetype   Set the filetype of the file
    */
    public function __construct ($filetype = NULL) {
        $this->workbook = new Workbook();
        $this->validParserTypes = array('XML', 'CSV', 'TSV', 'HTML', 'JSON', 'XLSX');
        $this->validWriterTypes = array('XML', 'CSV', 'TSV', 'HTML', 'JSON');
        if (isset($filetype)) {
            $this->setParserType($filetype);
            $this->setWriterType($filetype);
        }
    }

    /**
    * Export data as file
    * 
    * @param    string  $target     Where to write the file
    * @param    string  $filetype   Type of the file to be written
    * @param    string  $options    Options
    * @throws   Exception           If filetype is not supported
    * @throws   Exception           If error writing file
    */
    public function exportFile ($target, $fileType, $options = NULL) {
        $this->setWriterType($fileType);
        $this->writer->exportFile($target, $options);
    }
    
    /**
    * Get specified worksheet
    * 
    * @param    int     $index      Worksheet index
    * @return   Worksheet
    * @throws   Exception           If worksheet with specified index is not found
    */
    public function getWorksheet ($index = 1) {
        return $this->workbook->getWorksheet($index);
    }
    
    /**
    * Get all worksheets
    *
    * @return   array
    */
    public function getWorksheets () {
        return $this->workbook->getWorksheets();
    }
    
    /**
    * Insert a worksheet
    * 
    * @param    Worksheet   $worksheet  Worksheet to be inserted
    */
    public function insertWorksheet (Worksheet $worksheet = NULL) {
        $this->workbook->insertWorksheet($worksheet);
    }

    /**
    * Load file to parser
    * 
    * @param    string  $filepath   Path to file
    * @param    string  $filetype   Set the filetype of the file which will be parsed
    * @param    string  $options    Options
    * @throws   Exception           If filetype is not supported
    * @throws   Exception           If file being loaded doesn't exist
    * @throws   Exception           If file extension doesn't match
    * @throws   Exception           If error reading the file
    */
    public function loadFile ($filePath, $fileType, $options = NULL) {
        $this->setParserType($fileType);
        $this->parser->loadFile($filePath, $options);
    }
    
    /**
    * Load string to parser
    * 
    * @param    string  $filepath   Path to file
    * @param    string  $filetype   Set the filetype of the file which will be parsed
    * @throws   Exception           If filetype is not supported
    */
    public function loadString ($string, $fileType) {
        $this->setParserType($fileType);
        $this->parser->loadString($string);
    }
    
    /**
    * Remove a worksheet
    * 
    * @param    int   $index  Worksheet index to be removed
    */
    public function removeWorksheet ($index) {
        $this->workbook->removeWorksheet($index);
    }

    /**
    * Construct a SimpleExcel Parser
    * 
    * @param    string  $filetype   Set the filetype of the file which will be parsed (XML/CSV/TSV/HTML/JSON)
    * @throws   Exception           If filetype is not supported
    */
    protected function setParserType($filetype){
        $filetype = strtoupper($filetype);
        if ($filetype != $this->parserType) {
            if(!in_array($filetype, $this->validParserTypes)){
                throw new \Exception('Filetype '.$filetype.' is not supported', SimpleExcelException::FILETYPE_NOT_SUPPORTED);
            }
            $parser_class = 'SimpleExcel\\Parser\\'.$filetype.'Parser';
            $this->parser = new $parser_class($this->workbook);
            $this->parserType = $filetype;
        }
    }

    /**
    * Construct a SimpleExcel Writer
    * 
    * @param    string  $filetype   Set the filetype of the file which will be written
    * @throws   Exception           If filetype is not supported
    */
    protected function setWriterType ($filetype) {
        $filetype = strtoupper($filetype);
        if ($filetype != $this->writerType) {
            if(!in_array($filetype, $this->validWriterTypes)) {
                throw new \Exception('Filetype '.$filetype.' is not supported', SimpleExcelException::FILETYPE_NOT_SUPPORTED);
            }
            $writer_class = 'SimpleExcel\\Writer\\'.$filetype.'Writer';
            $this->writer = new $writer_class($this->workbook);
            $this->writerType = $filetype;
        }
    }
    
    /**
    * Get data as string
    * 
    * @param    string  $filetype   Document format for the string to be returned
    * @param    string  $options    Options
    * @return   string
    * @throws   Exception           If filetype is not supported
    */
    public function toString ($filetype, $options = NULL) {
        $this->setWriterType($filetype);
        return $this->writer->toString($options);
    }
}
