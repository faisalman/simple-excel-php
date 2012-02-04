<?php
/**
 * Defines SimpleExcel writer interface
 * 
 * @author	Faisalman
 * @package	SimpleExcel
 */

/** define parser interface */
interface SimpleExcel_Writer_Interface
{
	public function addRow($values);
	public function saveFile($filename);
}

?>
