<?php
/**
 * SimpleExcel class for parsing Microsoft Excel CSV Spreadsheet
 *  
 * @author	Faisalman
 * @package	SimpleExcel
 */
class SimpleExcel_Parser_CSV implements SimpleExcel_Parser_Interface
{
	/**
	 * Holds the parsed result
	 * 
	 * @access	private
	 * @var		array
	 */
	private $table_arr;
			
	/**
	 * @param	string	$file_url	Path to CSV file (optional)
	 * @return	void
	 */
	public function __construct($file_url = NULL){
		if(isset($file_url)) $this->loadFile($file_url);
	}

	/**
	 * Get value of the specified cell
	 * 
	 * @param	int	$row_num	Row number
	 * @param	int	$col_num	Column number
	 * @return	mixed			Returns an array or FALSE if cell doesn't exist
	 */
	public function getCell($row_num, $col_num){
		
		// check whether the cell exists
		if(!isset($this->table_arr[$row_num-1][$col_num-1])){
			throw new Exception('Cell '.$row_num.','.$col_num.' doesn\'t exist');
			return FALSE;
		}
		return $this->table_arr[$row_num-1][$col_num-1];
	}

	/**
	 * Get datatype of the specified cell
	 * 
	 * @param	int	$row_num	Row number
	 * @param	int	$col_num	Column number
	 * @return	mixed			Returns 'String' or FALSE if cell doesn't exist
	 */
	public function getCellDatatype($row_num, $col_num){
		
		// check whether the cell exists
		if(!isset($this->table_arr[$row_num-1][$col_num-1])){
			throw new Exception('Cell '.$row_num.','.$col_num.' doesn\'t exist');
			return FALSE;
		}
		return 'String';
	}

	/**
	 * Get data of the specified column as an array
	 * 
	 * @param	int		$col_num	Column number
	 * @param	bool	$val_only	Ignored in CSV
	 * @return	mixed				Returns an array or FALSE if table doesn't exist
	 */
	public function getColumn($col_num, $val_only = TRUE){
		$col_arr = array();
		
		if(!isset($this->table_arr[0][$col_num-1])){
			throw new Exception('Column '.$col_num.' doesn\'t exist');
			return FALSE;
		}

		// get the specified column within every row
		foreach($this->table_arr as $row){
		    array_push($col_arr, $row[$col_num-1]);
		}
		
		// return the array, if empty then return FALSE
		return $col_arr;
	}

	/**
	 * Get data of all cells as an array
	 * 
	 * @return	mixed	Returns an array or FALSE if table doesn't exist
	 */
	public function getField(){
		if(isset($this->table_arr)){
			return $this->table_arr;
		} else {
			throw new Exception('Field is empty');
			return FALSE;
		}
	}
	
	/**
	 * Get data of the specified row as an array
	 * 
	 * @param	int		$row_num	Row number
	 * @param	bool	$val_only	Ignored in CSV
	 * @return	mixed				Returns an array FALSE if row doesn't exist
	 */
	public function getRow($row_num, $val_only = TRUE){
		if(!isset($this->table_arr[$row_num-1])){
			throw new Exception('Row '.$row_num.' doesn\'t exist');			
			return FALSE;				
		}

		// return the array			
		return $this->table_arr[$row_num-1];
	}

	/**
	 * Load the CSV file to be parsed
	 * 
	 * @param	string	$file_url	Path to CSV file
	 * @return	bool				Returns TRUE if file exist and valid, FALSE if does'nt
	 */
	public function loadFile($file_path){

		$file_extension = strtoupper(pathinfo($file_path, PATHINFO_EXTENSION));

		if(!file_exists($file_path)){
			throw new Exception('File doesn\'t exist');
			return FALSE;
		} else if($file_extension != 'CSV'){
			throw new Exception('File isn\'t a CSV Spreadsheet');
			return FALSE;
		}
		
        if(($handle = fopen($file_path, 'r')) !== FALSE){
        
            $this->table_arr = array();
           
            // first, assume the delimiter is semicolon
            while(($line = fgetcsv($handle, 0, ';')) !== FALSE){
                // check the number of values in each line
                if(count($line) > 1){
                    array_push($this->table_arr, $line);
                } else {
                    // if a line only contains 1 value
                    // maybe our assumption in the beginning was wrong
                    // empty the array back
                    $this->table_arr = array();
                    // break this loop
                    break;
                }
            }
            
            // if the array is still empty, maybe because the values are separated by commas
            if(count($this->table_arr) < 1){
                // try again with comma as the delimiter
                while(($line = fgetcsv($handle, 0, ',')) !== FALSE){
                    array_push($this->table_arr, $line);
                }
            }
            
            fclose($handle);
            
        } else {
            throw new Exception('Error reading the file');
			return FALSE;
        }
					
		// load succeed :)
		return TRUE;
	}
}
?>
