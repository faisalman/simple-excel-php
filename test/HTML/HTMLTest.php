<?php

use SimpleExcel\SimpleExcel;

require_once('src/SimpleExcel/SimpleExcel.php');

class HTMLTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $excel = new SimpleExcel('HTML');
        return $excel;
    }

    /**
     * @depends testConstruct
     */
    public function testParser(SimpleExcel $excel)
    {
        $excel->parser->loadFile('test/HTML/test.html');
        $this->assertEquals(array('ID', 'Nama', 'Kode Wilayah'), $excel->parser->getRow(1));
        $this->assertEquals(array('1', 'Kab. Bogor', '1'), $excel->parser->getRow(2));
    }
    
    /**
     * @depends testConstruct
     */
    public function testWriter(SimpleExcel $excel)
    {
        $excel->writer->addRow(array('ID', 'Nama', 'Kode Wilayah'));
        $this->assertEquals('<table><tr><td>ID</td><td>Nama</td><td>Kode Wilayah</td></tr></table>', $excel->writer->saveString());
    }
}

?>
