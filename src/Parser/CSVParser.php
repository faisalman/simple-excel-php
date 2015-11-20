<?php

namespace SimpleExcel\Parser;

/**
 * SimpleExcel class for parsing Microsoft Excel CSV Spreadsheet
 *
 * @author  Faisalman
 * @package SimpleExcel
 */
class CSVParser extends BaseParser implements IParser
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
     * Load the CSV file to be parsed.
     *
     * @param string $filePath Path to CSV file.
     * @return bool
     */
    public function loadFile($filePath)
    {
        if (!$this->isFileReady($filePath)) {
            return;
        }

        $this->loadString(file_get_contents($filePath));
    }

	/**
	 * {@inheritdoc}
	 *
	 * @link http://stackoverflow.com/questions/3997336/explode-php-string-by-new-line
	 *
	 * @param string $string String with CSV format
	 * @return bool
	 */
	public function loadString($string)
	{
        $this->table_arr = array();

        $pattern = "/\r\n|\n|\r/";
        $lines   = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY);
        $total   = count($lines);

        if ($total == 0) {
            return;
        }

        $line = $lines[0];
        if (!isset($this->delimiter)) {
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
        $this->table_arr = $rows;
    }

    /**
    * Set delimiter that should be used to parse CSV document
    *
    * @param    string  $delimiter   Delimiter character
    */
    public function setDelimiter($delimiter){
        $this->delimiter = $delimiter;
    }
}
