<?php

use SimpleExcel\SimpleExcel;

class JSONTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $excel = new SimpleExcel('JSON');
        $this->assertInstanceOf('SimpleExcel\SimpleExcel', $excel);
    }

    public function testParser()
    {
        $excel = new SimpleExcel('JSON');
        $excel->parser->loadFile('test/JSON/test.json');

        $this->assertEquals(array('ID', 'Nama', 'Kode Wilayah'), $excel->parser->getRow(1));
        $this->assertEquals(array('1', 'Kab. Bogor', '1'), $excel->parser->getRow(2));
    }

    public function testWriter()
    {
        $excel = new SimpleExcel('JSON');
        $excel->writer->addRow(array('ID', 'Nama', 'Kode Wilayah'));

        $this->assertEquals('[{"0":"ID","1":"Nama","2":"Kode Wilayah"}]', $excel->writer->saveString());
    }
}
