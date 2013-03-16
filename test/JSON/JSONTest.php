<?php

use SimpleExcel\SimpleExcel;

require_once('src/SimpleExcel/SimpleExcel.php');

class JSONTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $excel = new SimpleExcel('JSON');
        return $excel;
    }

    /**
     * @depends testConstruct
     */
    public function testParser(SimpleExcel $excel)
    {
        $excel->parser->loadFile('test/JSON/test.json');
        $this->assertEquals(array('ID', 'Nama', 'Kode Wilayah'), $excel->parser->getRow(1));
        $this->assertEquals(array('1', 'Kab. Bogor', '1'), $excel->parser->getRow(2));
    }
    
    /**
     * @depends testConstruct
     */
    public function testWriter(SimpleExcel $excel)
    {
        $excel->writer->addRow(array('ID', 'Nama', 'Kode Wilayah'));
        $this->assertEquals('[{"0":"ID","1":"Nama","2":"Kode Wilayah"}]', $excel->writer->saveString());
    }
}

?>
