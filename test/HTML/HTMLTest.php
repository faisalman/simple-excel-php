<?php

use SimpleExcel\SimpleExcel;

class HTMLTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $excel = new SimpleExcel('HTML');
        $this->assertInstanceOf('SimpleExcel\SimpleExcel', $excel);
    }

    public function testParser()
    {
        $excel = new SimpleExcel('HTML');
        $excel->parser->loadFile('test/HTML/test.html');

        $this->assertEquals(array('ID', 'Nama', 'Kode Wilayah'), $excel->parser->getRow(1));
        $this->assertEquals(array('1', 'Kab. Bogor', '1'), $excel->parser->getRow(2));
    }

    public function testWriter()
    {
        $excel = new SimpleExcel('HTML');

        $excel->writer->addRow(array('ID', 'Name', 'Kode Wilayah'));
        $this->assertEquals('<table><tr><td>ID</td><td>Name</td><td>Kode Wilayah</td></tr></table>', $excel->writer->saveString());
    }
}
