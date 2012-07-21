<?php
/**
 * Simple Excel
 * 
 * A PHP library with simplistic approach for parsing/writing data from/to 
 * Microsoft Excel XML/CSV format
 *  
 * Copyright (c) 2011-2012 Faisalman <fyzlman@gmail.com>
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
 * @copyright   2011-2012 (c) Faisalman
 * @license     http://www.opensource.org/licenses/mit-license
 * @link        http://github.com/faisalman/simple-excel-php
 * @package     SimpleExcel
 * @version     0.2.4
 */

/** autoload all interfaces & classes */
function __autoload($class_name) 
{
    $relative_path = str_replace('_', DIRECTORY_SEPARATOR, $class_name).'.php';
    $file_path = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$relative_path;
    if(!file_exists($file_path)){
        return FALSE;
    }
    require_once $file_path;
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
    * @var SimpleExcel_Parser_{filetype}
    */
    public $parser;

    /**
    * 
    * @var  SimpleExcel_Writer_{filetype}
    */
    public $writer;

    /**
    * SimpleExcel constructor method
    * 
    * @param    string  $filetype   Set the filetype of the file which will be parsed (XML/CSV)
    * @return   void
    */
    public function __construct($filetype = 'XML'){
        $this->constructParser($filetype);
        $this->constructWriter($filetype);
    }

    /**
    * Construct a SimpleExcel Parser
    * 
    * @param    string  $filetype   Set the filetype of the file which will be parsed (XML/CSV)
    * @return   bool
    * @throws   Exception           If filetype is neither XML/CSV
    */
    public function constructParser($filetype){
        $filetype = strtoupper($filetype);
        if(preg_match('/(XML|CSV)/',$filetype)){
            $parser_class = 'SimpleExcel_Parser_'.$filetype;
            $this->parser = new $parser_class();
            return TRUE;
        } else {
            throw new Exception('Filetype '.$filetype.' is not supported', SimpleExcel_Exception_Enum::FileTypeNotSupported);
            return FALSE;
        }
    }

    /**
    * Construct a SimpleExcel Writer
    * 
    * @param    string  $filetype   Set the filetype of the file which will be written (XML/CSV)
    * @return   bool
    * @throws   Exception           If filetype is neither XML/CSV
    */
    public function constructWriter($filetype){
        $filetype = strtoupper($filetype);
        if(preg_match('/(XML|CSV)/',$filetype)){
            $writer_class = 'SimpleExcel_Writer_'.$filetype;
            $this->writer = new $writer_class();
            return TRUE;
        } else {
            throw new Exception('Filetype '.$filetype.' is not supported', SimpleExcel_Exception_Enum::FileTypeNotSupported);
            return FALSE;
        }
    }
}
