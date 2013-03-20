<?php

namespace SimpleExcel\Writer;

/**
 * Defines SimpleExcel writer interface
 * 
 * @author  Faisalman
 * @package SimpleExcel
 */

/** define writer interface */
interface IWriter
{
    public function exportFile($fileName, $target, $options);
    public function toString($options);