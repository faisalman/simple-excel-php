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
    public function exportFile($fileName, $target);
    public function toString();

    /**
    * @deprecated since v0.4
    */
    public function saveString();
    public function saveFile($filename, $target);
    public function addRow($values);
    public function setData($values);
}

?>
