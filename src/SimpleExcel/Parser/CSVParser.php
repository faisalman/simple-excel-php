<?php
 
namespace SimpleExcel\Parser;

use SimpleExcel\Enums\Datatype;
use SimpleExcel\Enums\SimpleExcelException;
use SimpleExcel\Spreadsheet\Workbook;
use SimpleExcel\Spreadsheet\Worksheet;
use SimpleExcel\Spreadsheet\Cell;

/**
 * SimpleExcel class for parsing Microsoft Excel CSV Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class CSVParser extends BaseParser
{    
    /**
	* Defines delimiter character
	* 
	* @access   protected
	* @var      string
	*/
	protected $delimiter;
	
	/**
	* Defines valid file extension
	* 
	* @access   protected
	* @var      string
	*/
	protected $file_extension = 'csv';

	/**
	* Load the string to be parsed
	* 
	* @param    string  $str    String with CSV format
	* @param    array   $options    Options
	*/
	public function loadString ($str, $options = NULL) {
		$this->workbook = new Workbook();
        
        // 1. Split into lines by newline http://stackoverflow.com/questions/3997336/explode-php-string-by-new-line 
		$pattern = "/\r\n|\n|\r/";
		$lines   = preg_split($pattern, $str, -1, PREG_SPLIT_NO_EMPTY);
		$total   = count($lines);
		
		// There are no lines to parse
		if ($total == 0) {
			return;
		}
        
        if (isset($options['delimiter'])) {
            $this->delimiter = $options['delimiter'];
        }
		
		// 2. Guess delimiter if none set
		$line = $lines[0];
		if (!isset($this->delimiter)) {
			// do guess work
			$separators = array(';' => 0, ',' => 0);
			foreach ($separators as $sep => $count) {
				$args  = str_getcsv($sep, $line);
				$count = count($args);
				
				$separators[$sep] = $count;
			}
			
			$sep = ',';
			if (($separators[';'] > $separators[','])) {
				$sep = ';';
			}
			
			$this->delimiter = $sep;
		}
		
		// 3. Parse the lines into rows,cols
		$max  = 0;
		$min  = PHP_INT_MAX;
		$cols = 0;
		$sep  = $this->delimiter;
		$rows = array(); 
		foreach ($lines as $line) {
			$args   = str_getcsv($line, $sep);
			$rows[] = $args;
			
			$cols = count($args);
			if ($cols > $max) {
				$max = $cols;
			}
			if ($cols < $min) {
				$min = $cols;
			}
		}

		// 4. Expand those rows which have less cols than max cols found
		if ($min != $max) {
			foreach ($rows as $i => $row) {
				$c = count($row);
				while ($c < $max) {
					$row[] = ""; // fill with empty strings
					$c += 1;
				}
				$rows[$i] = $row;
			}
		}

        // convert each cell value to SimpleExcel Cell instance
        foreach ($rows as $i => $row) {
            foreach ($row as $j => $cell) {
                $rows[$i][$j] = new Cell($cell, Datatype::TEXT);
            }
        }
        $worksheet = new Worksheet();
        $worksheet->setRecords($rows);
		$this->workbook->insertWorksheet($worksheet);
	}
}
