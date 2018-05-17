<?php

namespace Faisalman\SimpleExcel\Writer;

/**
 * Defines SimpleExcel writer interface
 * 
 * @author  Faisal Salman
 * @package Faisalman\SimpleExcel
 */

/** define writer interface */
interface IWriter
{
    public function exportFile($target, $options);
    public function toString($options);
}
