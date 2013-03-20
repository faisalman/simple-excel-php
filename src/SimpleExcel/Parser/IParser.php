<?php
 
namespace SimpleExcel\Parser;

/**
 * Defines SimpleExcel parser interface
 * 
 * @author  Faisalman
 * @package SimpleExcel
 */

/** define parser interface */
interface IParser
{
    public function loadFile($file_path, $options);
    public function loadString($str, $options);
}
