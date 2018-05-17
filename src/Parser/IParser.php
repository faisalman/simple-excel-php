<?php
 
namespace Faisalman\SimpleExcel\Parser;

/**
 * Defines SimpleExcel parser interface
 * 
 * @author  Faisal Salman
 * @package Faisalman\SimpleExcel
 */

/** define parser interface */
interface IParser
{
    public function loadFile($file_path, $options);
    public function loadString($str, $options);
}
