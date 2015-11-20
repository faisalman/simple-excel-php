<?php

/*
 +------------------------------------------------------------------------+
 | The SimpleExcel Component                                              |
 +------------------------------------------------------------------------+
 | Copyright © 2011-2013 Faisalman <fyzlman@gmail.com>                    |
 | Copyright © 2015 (c) Serghei Iakovlev <me@klay.me>                     |
 +------------------------------------------------------------------------+
 | This source file is subject to the MIT License that is bundled         |
 | with this package in the file LICENSE.md.                              |
 |                                                                        |
 | If you did not receive a copy of the license and are unable to         |
 | obtain it through the world-wide-web, please send an email             |
 | to me@klay.me so I can send you a copy immediately.                    |
 +------------------------------------------------------------------------+
*/

namespace SimpleExcel\Writer;

/**
 * SimpleExcel class for writing Microsoft Excel 2003 XML Spreadsheet
 *
 * @package SimpleExcel\Writer
 */
class XMLWriter extends BaseWriter implements IWriter
{
    /**
     * Defines content-type for HTTP header
     *
     * @var  string
     */
    protected $content_type = 'application/xml';

    /**
     * Defines file extension to be used when saving file
     *
     * @var string
     */
    protected $file_extension = 'xml';

    /**
     * Array containing document properties
     *
     * @var array
     */
    private $doc_prop;


    /**
     * XMLWriter constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->doc_prop = array(
            'Author'     => 'SimpleExcel',
            'Company'    => 'SimpleExcel',
            'Created'    => gmdate('Y-m-d\TH:i:s\Z'),
            'Keywords'   => 'SimpleExcel',
            'LastAuthor' => 'SimpleExcel',
            'Version'    => '12.00'
        );
    }

    /**
     * Adding row data to XML.
     *
     * @param array $values An array contains ordered value for every cell.
     * @return $this
     */
    public function addRow($values)
    {
        $row = &$this->tabl_data;
        $row .= '<Row ss:AutoFitHeight="0">';

        foreach ($values as $val) {
            if (is_array($val)) {
                $value = $val[0];
                $dataType = $val[1];
            } else {
                $value = $val;
                $dataType = is_string($val) ? 'String' : (is_numeric($val) ? 'Number' : 'String');
            }

            $value = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);

            $row .= sprintf('<Cell><Data ss:Type="%s">%s</Data></Cell>', $dataType, $value);
        }

        $row .= '</Row>';

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function saveString()
    {
        $content = <<<XML
<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
  xmlns:o="urn:schemas-microsoft-com:office:office"
  xmlns:x="urn:schemas-microsoft-com:office:excel"
  xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
  xmlns:html="http://www.w3.org/TR/REC-html40">
    <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
        %s
    </DocumentProperties>
    <Worksheet ss:Name="Sheet1">
        <Table>
            %s
        </Table>
    </Worksheet>
</Workbook>
XML;

        $docProperties = '';

        foreach($this->doc_prop as $propName => $propVal){
            $docProperties .= sprintf("<%s>%s</%s>\n", $propName, $propVal, $propName);
        }

        return sprintf($content, $docProperties, $this->tabl_data);
    }

    /**
     * Set XML data.
     *
     * @param array $values An array contains ordered value of arrays for all fields
     * @return $this
     */
    public function setData($values)
    {
        if (!is_array($values)) {
            $values = array($values);
        }

        $this->tabl_data = "";

        foreach ($values as $value) {
            $this->addRow($value);
        }

        return $this;
    }

    /**
    * Set a document property of the XML.
    *
    * @param string $prop Document property to be set
    * @param string $val  Value of the document property
    * @return $this
    */
    public function setDocProp($prop, $val)
    {
        $this->doc_prop[$prop] = $val;

        return $this;
    }
}
