<?php
/**
 * SimpleExcel class for parsing Microsoft Excel 2003 XML Spreadsheet
 *  
 * @author	Faisalman
 * @package	SimpleExcel
 */
class SimpleExcel_Parser_XML implements SimpleExcel_Parser_Interface
{
	/**
	 * Holds the parsed result
	 * 
	 * @access	private
	 * @var		array
	 */
	private $table_arr;
	
	/**
	 * @param	string	$file_url	Path to XML file (optional)
	 * @return	SimpleExcel_Parser_XML
	 */
	public function __construct($file_url = NULL) {
		$this->loadFile($file_url);
	}

	/**
	 * Extract attributes from SimpleXMLElement object
	 * 
	 * @access	private
	 * @param	object	$attrs_obj
	 * @return 	array
	 */
	private function getAttributes($attrs_obj) {
		$attrs_arr = array();
		foreach ($attrs_obj as $attrs) {
			$attrs = (array) $attrs;
			foreach ($attrs as $attr) {
				$attr_keys = array_keys($attr);
				$attrs_arr[$attr_keys[0]] = $attr[$attr_keys[0]];
			}
		}
		return $attrs_arr;
	}

	/**
	 * Get value of the specified cell
	 * 
	 * @param	int	$row_num	Row number
	 * @param	int	$col_num	Column number
	 * @return	array			Returns an array.
	 * @throws	Exception		If the cell identified doesn't exist.
	 */
	public function getCell($row_num, $col_num) {
		// check whether the cell exists
		if (!isset($this->table_arr['table_contents'][$row_num-1]['row_contents'][$col_num-1])) {
			throw new Exception('Cell '.$row_num.','.$col_num.' doesn\'t exist');
		}
		return $this->table_arr['table_contents'][$row_num-1]['row_contents'][$col_num-1]['value'];
	}

	/**
	 * Get datatype of the specified cell
	 * 
	 * @param	int	$row_num	Row number
	 * @param	int	$col_num	Column number
	 * @return	array			Returns an array.
	 * @throws	Exception		If the cell requested doesn't exist.
	 */
	public function getCellDatatype($row_num, $col_num) {
		// check whether the cell exists
		if(!isset($this->table_arr['table_contents'][$row_num-1]['row_contents'][$col_num-1])) {
			throw new Exception('Cell '.$row_num.','.$col_num.' doesn\'t exist');
		}
		return $this->table_arr['table_contents'][$row_num-1]['row_contents'][$col_num-1]['datatype'];
	}

	/**
	 * Get data of the specified column as an array
	 * 
	 * @param	int		$col_num	Column number
	 * @param	bool		$val_only	Returns (value only | complete data) for every cell, default to TRUE
	 * @return	array				Returns an array.
	 * @throws	Exception			If the column requested doesn't exist.
	 */
	public function getColumn($col_num, $val_only = TRUE) {
		$col_arr = array();
		
		if (!isset($this->table_arr['table_contents'])) {
			throw new Exception('Column '.$col_num.' doesn\'t exist');
		}

		// get the specified column within every row
		foreach ($this->table_arr['table_contents'] as $row) {
		    if ($row['row_contents']) {
			    if(!$val_only) {
				    array_push($col_arr,$row['row_contents'][$col_num-1]);
			    } else {
				    array_push($col_arr,$row['row_contents'][$col_num-1]['value']);
			    }
			}
		}
		
		// return the array, if empty then return FALSE
		return $col_arr;
	}

	/**
	 * Get data of all cells as an array
	 * 
	 * @return	mixed			Returns an array.
	 * @throws	Exception		If the field is empty.
	 */
	public function getField() {
		if (isset($this->table_arr)) {
			return $this->table_arr;
		}
		throw new Exception('Field is empty');
	}
	
	/**
	 * Get data of the specified row as an array
	 * 
	 * @param	int		$row_num	Row number
	 * @param	bool		$val_only	Returns (value only | complete data) for every cell, default to TRUE
	 * @return	array				Returns an array.
	 * @throws	Exception			When a row is requested that doesn't exist.
	 */
	public function getRow($row_num, $val_only = TRUE) {
		if (!isset($this->table_arr['table_contents'][$row_num-1]['row_contents'])) {
			throw new Exception('Row '.$row_num.' doesn\'t exist');						
		}
		$row = $this->table_arr['table_contents'][$row_num-1]['row_contents'];
		$row_arr = array();
                        
		// get the specified column within every row 
		foreach ($row as $cell) {
			if (!$val_only) {
				array_push($row_arr, $cell);
			} else {
				array_push($row_arr, $cell['value']);
			}
		}

		// return the array, if empty then return FALSE			
		return $row_arr;
	}

	/**
	 * Load the XML file to be parsed
	 * 
	 * @param	string	$file_url	Path to XML file
	 * @param	bool	$escape		Set whether input had to be escaped from HTML tags, default to TRUE
	 * @return	bool				Returns TRUE if file exist and valid, FALSE if does'nt
	 */
	public function loadFile($file_path) {

		$file_extension = strtoupper(pathinfo($file_path, PATHINFO_EXTENSION));

		if (!file_exists($file_path)) {
			throw new Exception('File doesn\'t exist');
		} else if ($file_extension != 'XML') {
			throw new Exception('File isn\'t an Excel XML 2003 Spreadsheet');
		}
							
		// assign simpleXML object
		$simplexml_table = simplexml_load_file($file_path);
		
		// get XML namespace
		$xmlns = $simplexml_table->getDocNamespaces();

		// check file extension and XML namespace		
		if ($xmlns['ss'] != 'urn:schemas-microsoft-com:office:spreadsheet') {
			throw new Exception('File isn\'t a valid Excel XML 2003 Spreadsheet');
		}

		// extract document properties
		$doc_props = (array)$simplexml_table->DocumentProperties;
		$this->table_arr['doc_props'] = $doc_props;
				
		$rows = $simplexml_table->Worksheet->Table->Row;
		$row_num = 1;
		$this->table_arr = array(
			'doc_props' => array(),
			'table_contents' => array()
		);
					
		// loop through all rows		
		foreach ($rows as $row) {	

			// check whether ss:Index attribute exist in this row
			$row_index = $row->xpath('@ss:Index');
			
			// if exist, push empty value until the specified index
			if (count($row_index) > 0) {
				$gap = $row_index[0]-count($this->table_arr['table_contents']);
				for($i = 1; $i < $gap; $i++){
					array_push($this->table_arr['table_contents'], array(
						'row_num' => $row_num,
						'row_contents' => '',
						//'row_attrs' => $row_attrs_arr
					));
					$row_num += 1;
				}
			}

			$cells = $row->Cell;
			$row_attrs = $row->xpath('@ss:*');
			$row_attrs_arr = $this->getAttributes($row_attrs);
			$row_arr = array();
			$col_num = 1;
			
			// loop through all row's cells
			foreach ($cells as $cell) {	
			
				// check whether ss:Index attribute exist
				$cell_index = $cell->xpath('@ss:Index');
				
				// if exist, push empty value until the specified index
				if (count($cell_index) > 0) {
					$gap = $cell_index[0]-count($row_arr);
					for ($i = 1; $i < $gap; $i++) {
						array_push ($row_arr, array(
							'row_num' => $row_num,
							'col_num' => $col_num,
							'datatype' => '',
							'value' => '',							
							//'cell_attrs' => '',
							//'data_attrs' => ''
						));
						$col_num += 1;
					}
				}

				// get all cell and data attributes				
				//$cell_attrs = $cell->xpath('@ss:*');
				//$cell_attrs_arr = $this->getAttributes($cell_attrs);
				$data_attrs = $cell->Data->xpath('@ss:*');
				$data_attrs_arr = $this->getAttributes($data_attrs);
				$cell_datatype = $data_attrs_arr['Type']; 
				
				// extract data from cell
				$cell_value = (string) $cell->Data;
				
				// escape input from HTML tags
				$cell_value = filter_var($cell_value, FILTER_SANITIZE_SPECIAL_CHARS);
				
				// push column array
				array_push($row_arr, array(
					'row_num' => $row_num,					
					'col_num' => $col_num,
					'datatype' => $cell_datatype,		
					'value' => $cell_value,					
					//'cell_attrs' => $cell_attrs_arr,
					//'data_attrs' => $data_attrs_arr
				));
				$col_num += 1;
			}

			// push row array
			array_push($this->table_arr['table_contents'], array(
				'row_num' => $row_num,
				'row_contents' => $row_arr,
				//'row_attrs' => $row_attrs_arr
			));
			$row_num += 1;
		}
					
		// load succeed :)
		return TRUE;
	}
}
