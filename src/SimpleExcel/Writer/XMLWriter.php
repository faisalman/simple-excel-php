<?php

namespace SimpleExcel\Writer;

use SimpleExcel\Enums\Datatype;

/**
 * SimpleExcel class for writing Microsoft Excel 2003 XML Spreadsheet
 *  
 * @author  Faisalman
 * @package SimpleExcel
 */
class XMLWriter extends BaseWriter
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
     * @param   Workbook    reference to workbook
     * @return  void
     */
    public function __construct(&$workbook){
        parent::__construct($workbook);
        $this->doc_prop = array(
            'Author' => 'SimpleExcel.php',
            'Company' => 'SimpleExcel.php',
            'Created' => gmdate("Y-m-d\TH:i:s\Z"),
            'Keywords' => 'SimpleExcel.php',
            'LastAuthor' => 'SimpleExcel.php'
        );
    }

    /**
     * Get document content as string
     * 
	 * @param   array   $options    Options
     * @return  string              Content of document
     */
    public function toString ($options = NULL) {
        $properties = isset($options['properties']) ? $options['properties'] : $this->doc_prop;
        $content = '<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">';
        foreach ($properties as $propname => $propval) {
            $content .= '
  <'.$propname.'>'.$propval.'</'.$propname.'>';
        }
        $content .= '
 </DocumentProperties>';
        foreach ($this->workbook->getWorksheets() as $i => $worksheet) {
            $content .= '
 <Worksheet ss:Name="Sheet' . ($i + 1) . '">
  <Table>';
            foreach ($worksheet->getRecords() as $record) {
                $content .= '
   <Row>';   
                foreach ($record as $cell) {
                    $datatype = 'String';
                    switch ($cell->datatype) {
                        case Datatype::NUMBER:
                            $datatype = 'Number';
                            break;
                        case Datatype::LOGICAL:
                            $datatype = 'Boolean';
                            break;
                        case Datatype::DATETIME:
                            $datatype = 'DateTime';
                            break;
                        case Datatype::ERROR:
                            $datatype = 'Error';
                    }
                    $content .= '
    <Cell>
     <Data ss:Type="' . $datatype . '">' . $cell->value . '</Data>
    </Cell>';
                }
                $content .= '
   </Row>';
            }
            $content .= '
  </Table>
 </Worksheet>';
        }
        $content .= '
</Workbook>';
        return $content;
    }
}
