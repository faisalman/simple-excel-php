<?php

namespace SimpleExcel\Writer;

/**
 * SimpleExcel class for writing Microsoft Excel 2003 XML Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class XMLWriter implements IWriter
{
    /**
     * Holds data part of XML
     * 
     * @access  private
     * @var     string
     */
    private $xml_data;

    /**
     * Array containing document properties
     * 
     * @access  private
     * @var     array
     */
    private $doc_prop;

    /**
     * @return  void
     */
    public function __construct(){
        $this->doc_prop = array(
            'Author' => 'SimpleExcel',
            'Company' => 'SimpleExcel',
            'Created' => gmdate("Y-m-d\TH:i:s\Z"),
            'Keywords' => 'SimpleExcel',
            'LastAuthor' => 'SimpleExcel',
            'Version' => '12.00'
        );
    }

    /**
     * Adding row data to XML
     * 
     * @param   array   $values An array contains ordered value for every cell
     * @return  void
     */
    public function addRow($values){
        $row = &$this->xml_data;
        $row .= '
    <Row ss:AutoFitHeight="0">';

        foreach($values as $val){
            
            $value = '';
            $datatype = 'String';
            
            // check if given variable contains array
            if(is_array($val)){
                $value = $val[0];
                $datatype = $val[1];
            } else {
                $value = $val;
                $datatype = is_numeric($val) ? 'Number' : 'String';
            }
            
            // escape value from HTML tags
            $value = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
            
            $row .= '
    <Cell><Data ss:Type="'.$datatype.'">'.$value.'</Data></Cell>';
        }

        $row .= '
    </Row>';
    }

    /**
     * Export the XML document
     * 
     * @param   string  $filename   Name for the downloaded file (extension will be set automatically)
     * @param   string  $target     Save location
     * @return  void
     */
    public function saveFile($filename, $target = NULL){

        if(!isset($filename)){
            $filename = date('YmdHis');
        }
        if(!isset($target)){
            // write XML output to browser
            $target = 'php://output';
        }
        
        // set HTTP response header
        header('Content-Type: application/xml');
        header('Content-Disposition: attachment; filename='.$filename.'.xml');
        
        $content = '<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">';
 
        foreach($this->doc_prop as $propname => $propval){
            $content .= '
  <'.$propname.'>'.$propval.'</'.$propname.'>';
        }
 
        $content .= '
 </DocumentProperties>
 <Worksheet ss:Name="Sheet1">
  <Table>'.$this->xml_data.'
  </Table>
 </Worksheet>
</Workbook>';

        $fp = fopen($target, 'w');
        fwrite($fp, $content);
        fclose($fp);

        if($target == 'php://output'){
            // since there must be no data below downloaded XML
            exit();
        }
    }

    /**
    * Set XML data
    * 
    * @param    array   $values An array contains ordered value of arrays for all fields
    * @return   void
    */
    public function setData($values){
        if(!is_array($values)){
            $values = array($values);
        }
        $this->xml_data = ""; // reset the xml data.

        // append values as rows
        foreach ($values as $value) {
            $this->addRow($value);  
        }
    }

    /**
    * Set a document property of the XML
    * 
    * @param    string  $prop   Document property to be set
    * @param    string  $val    Value of the document property
    * @return   void
    */
    public function setDocProp($prop,$val){
        $this->doc_prop[$prop] = $val;
    }
}
?>
