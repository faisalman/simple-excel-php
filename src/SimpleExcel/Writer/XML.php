<?php
/**
 * SimpleExcel class for writing Microsoft Excel 2003 XML Spreadsheet
 *  
 * @author	Faisalman
 * @package	SimpleExcel
 */
class SimpleExcel_Writer_XML implements SimpleExcel_Writer_Interface
{
	/**
	 * Holds data part of XML
	 * 
	 * @access	private
	 * @var		string
	 */
	private $xml_data;

	/**
	 * Array containing document properties
	 * 
	 * @access	private
	 * @var		array
	 */
	private $doc_prop;
	
	/**
	 * @return	void
	 */
	public function __construct(){
		$this->doc_prop = array(
				'Author' => 'SimpleExcel',
				'Keywords' => 'SimpleExcel',
				'LastAuthor' => 'SimpleExcel'
				);
	}

	/**
	 * Adding row data to XML
	 * 
	 * @param	array	$values	An array contains ordered value for every cell
	 * @return	void
	 */
	public function addRow($values){
		$row = &$this->xml_data;
		$row .= '
   <Row ss:AutoFitHeight="0">';

		foreach($values as $val){
			
			// check if given variable contains array
			if(is_array($val)){
				$value = $val[0];
				$datatype = $val[1];
			} else {
				$value = $val;
				$datatype = is_numeric($val) ? 'Number' : 'String';
			}
			$row .= '
    <Cell><Data ss:Type="'.$datatype.'">'.$value.'</Data></Cell>';			
		}

		$row .= '
   </Row>';
	}

	/**
	 * Export the XML document
	 * 
	 * @param	string	$filename	Name for the downloaded file (extension will be set automatically)
	 * @return	void
	 */
	public function saveFile($filename){
		
		// set HTTP response header
		header('Content-Type: application/xml');
		header('Content-Disposition: attachment; filename='.$filename.'.xml');

		echo '<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>'.$this->doc_prop['Author'].'</Author>
  <Keywords>'.$this->doc_prop['Keywords'].'</Keywords>
  <LastAuthor>'.$this->doc_prop['LastAuthor'].'</LastAuthor>
  <Created>'.gmdate("Y-m-d\TH:i:s\Z").'</Created>
  <Version>12.00</Version>
 </DocumentProperties>
 <Worksheet ss:Name="Sheet1">
  <Table>'.$this->xml_data.'
  </Table>
 </Worksheet>
</Workbook>';
	}

	/**
	 * Set a document property of the XML
	 * 
	 * @param	string	$prop	Document property to be set
	 * @param	string	$val	Value of the document property
	 * @return	void
	 */
	public function setDocProp($prop,$val){
		$this->doc_prop[$prop] = $val;
	}
}
?>