<?php

namespace SimpleExcel\Writer;

/**
 * SimpleExcel class for writing Microsoft Excel 2003 XML Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class XMLWriter extends BaseWriter implements IWriter
{
    /**
     * Defines content-type for HTTP header
     * 
     * @access  protected
     * @var     string
     */
    protected $content_type = 'application/xml';

    /**
     * Defines file extension to be used when saving file
     * 
     * @access  protected
     * @var     string
     */
    protected $file_extension = 'xml';

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
    public function __construct(Workbook $workbook){
        parent::__construct($workbook);
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
     * Get document content as string
     * 
     * @return  string  Content of document
     */
    public function saveString(){
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
  <Table>'.$this->tabl_data.'
  </Table>
 </Worksheet>
</Workbook>';
        return $content;
    }

    /**
    * Set a document property of the XML
    * 
    * @param    string  $prop   Document property to be set
    * @param    string  $val    Value of the document property
    * @return   void
    */
    public function setDocProp($prop, $val){
        $this->doc_prop[$prop] = $val;
    }
}
?>
